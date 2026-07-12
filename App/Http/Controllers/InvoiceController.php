<?php

namespace App\Http\controllers;

use App\Core\Request;
use App\Core\Session;
use App\Model\QueryBuilder;
use Exception;
use App\Services\PdfService;
use App\Services\MailService;

class InvoiceController
{

    private string $tablename = 'invoices';
    private string $childTablename = 'invoice_items';
    private string $settingsTable = 'settings';

    private static function toEmail(): string { return env('INVOICE_TO_EMAIL'); }
    private const __EMAIL_SUBJECT = "Thank you for your Order!";
    private static string $__EMAIL_OPENING = "Dear %s,\nThank you for shopping at Gauri Mobiles. Please find your invoice attached.";

    public function edit($id)
    {
        $invoice = QueryBuilder::fetchOneRecord($this->tablename, ['id' => $id]);
        $items = QueryBuilder::fetchAllWithWhereCondition($this->childTablename, ['invoice_id' => $invoice->id]);
        return view('admin.invoices.edit', compact('invoice', 'items'));
    }

    public function update(Request $request)
    {
        $invoiceId = $request->only(['invoice_id'])['invoice_id'];

        try {
            $invoiceData = $request->only([
                'customer_name',
                'customer_email',
                'customer_phone',
                'billing_address',
                'payment_method',
                'subtotal',
                'discount',
                'total',
            ]);

            $items = $request->only(['product_name', 'product_description', 'quantity', 'invoice_item_total', 'price', 'item_id']);

            $updatInvoice = QueryBuilder::updateRecord($this->tablename, $invoiceData, $invoiceId);

            $deletedIds = $request->only(['deleted_items']);

            if (!empty($deletedIds)) {
                foreach ($deletedIds['deleted_items'] as $id) {
                    $deletedInvoiceItems = QueryBuilder::deleteRecord($this->childTablename, $id);
                }
            }

            $records = [];
            for ($i = 0; $i < count($items['product_name']); $i++) {
                $records[] = [
                    'id'                 => $items['item_id'][$i],
                    'product_name'       => $items['product_name'][$i],
                    'product_description' => $items['product_description'][$i],
                    'quantity'           => $items['quantity'][$i],
                    'total'              => $items['invoice_item_total'][$i],
                    'price'              => $items['price'][$i],
                    'invoice_id'         => $invoiceId,
                ];
            }

            $updateInvoiceItems = QueryBuilder::upsert('invoice_items', $records, [
                'product_name',
                'product_description',
                'quantity',
                'price',
                'total',
                'invoice_id',
            ]);

            if ($updateInvoiceItems || $updatInvoice || $deletedInvoiceItems) {
                QueryBuilder::commit();
                Session::flash('success', "Invoice Updated Successfully");
                return redirect('/admin/invoices/edit/' . $invoiceId);
            }

            QueryBuilder::rollback();
            Session::flash('error', "Something went wrong!!");
            return redirect('/admin/invoices/edit/' . $invoiceId);
        } catch (Exception $e) {
            QueryBuilder::rollback();
            $encodedError = base64_encode($e->getMessage());
            Session::flash('error', $encodedError);
            return redirect('/admin/invoices/edit/' . $invoiceId);
        }
    }

    public function viewInvoice(string $invoiceId)
    {
        $invoice = QueryBuilder::fetchWithJoins(
            $this->tablename,
            [[
                'table' => 'invoice_items',
                'base_column' => 'invoices.id',
                'join_column' => 'invoice_items.invoice_id',
                'type' => 'left'
            ]],
            ['invoices.*', 'invoice_items.*', 'invoices.total as invoice_total'],
            ['invoices.id' => $invoiceId]
        );

        $settingArr = QueryBuilder::fetchAll($this->settingsTable);
        $settings = [];
        foreach ($settingArr as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        return view('admin.invoices.view', compact('invoice', 'settings'));
    }

    public function insert(Request $request)
    {
        try {
            QueryBuilder::beginTransaction();

            $invoiceData = $request->only([
                'customer_name',
                'customer_email',
                'customer_phone',
                'billing_address',
                'payment_method',
                'subtotal',
                'discount',
                'total'
            ]);
            $invoiceData['invoice_number'] = "GM-" . (QueryBuilder::getCount($this->tablename) + 1);

            $invoiceItemsData = $request->only([
                'product_name',
                'product_description',
                'quantity',
                'invoice_item_total',
                'price'
            ]);

            $invoiceId = QueryBuilder::insertRecords($this->tablename, $invoiceData);

            if ($invoiceId) {
                $items = [];
                $productNames = $invoiceItemsData['product_name'];
                $productDescriptions = $invoiceItemsData['product_description'];
                $quantities = $invoiceItemsData['quantity'];
                $prices = $invoiceItemsData['price'];
                $totals = $invoiceItemsData['invoice_item_total'];

                foreach ($productNames as $index => $productName) {
                    $items[] = [
                        'invoice_id'    => $invoiceId,
                        'product_name'  => $productName,
                        'product_description' => $productDescriptions[$index],
                        'quantity'      => $quantities[$index],
                        'price'         => $prices[$index],
                        'total'         => $totals[$index]
                    ];
                }

                if (!empty($items)) {
                    $inserted = QueryBuilder::insertMultipleRecords('invoice_items', $items);

                    if (!$inserted) {
                        Session::flash('error', base64_encode("Something Went Wrong!!"));
                        QueryBuilder::rollback();
                        return redirect('/admin/invoices/add');
                    }
                }
            }

            QueryBuilder::commit();

            Session::flash('success', 'Invoice created successfully!');
            return redirect('/admin/invoices/view/' . $invoiceId);
        } catch (Exception $e) {
            Session::flash('error', base64_encode($e->getMessage()));
            QueryBuilder::rollback();
            return redirect('/admin/invoices/add');
        }
    }

    public function sendEmail(Request $request)
    {
        $invoiceId = $request->only(['invoiceId']);
        $invoiceData = QueryBuilder::fetchWithJoins(
            $this->tablename,
            [[
                'table' => 'invoice_items',
                'base_column' => 'invoices.id',
                'join_column' => 'invoice_items.invoice_id',
                'type' => 'left'
            ]],
            ['invoices.*', 'invoice_items.*', 'invoices.total as invoice_total'],
            ['invoices.id' => (int) $invoiceId['invoiceId']]
        );

        $settingArr = QueryBuilder::fetchAll($this->settingsTable);
        $settings = [];
        foreach ($settingArr as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        if (getEnvDetails() !== 'prod') {
            return $this->sendTestEmail($invoiceData, $settings);
        }

        // Generate PDF
        $pdfService = new PdfService(app('view'));
        $pdfBinary  = $pdfService->generateInvoicePdf($invoiceData, $settings);

        // Send Email
        $mailer = new MailService();

        try {
            $mailer->sendInvoice(
                $invoiceData[0]->customer_email,
                self::__EMAIL_SUBJECT,
                sprintf(self::$__EMAIL_OPENING, $invoiceData[0]->customer_name),
                $pdfBinary,
                $invoiceData[0]->invoice_number
            );

            return json_encode(['status' => true, 'message' => "Invoice sent successfully!"]);
        } catch (\Exception $e) {
            return json_encode(['status' => true, 'message' => base64_encode($e->getMessage())]);
        }
    }

    public function sendTestEmail($invoiceData, $settings)
    {
        $pdfService = new PdfService(app('view'));
        $pdfBinary  = $pdfService->generateInvoicePdf($invoiceData, $settings);

        // Send Email
        $mailer = new MailService();

        try {
            $mailer->sendInvoice(
                self::toEmail(),
                self::__EMAIL_SUBJECT,
                sprintf(self::$__EMAIL_OPENING, $invoiceData[0]->customer_name),
                $pdfBinary,
                $invoiceData[0]->invoice_number
            );

            return json_encode(['status' => true, 'message' => "Invoice sent successfully!"]);
        } catch (\Exception $e) {
            return json_encode(['status' => true, 'message' => base64_encode($e->getMessage())]);
        }
    }
}
