<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\View\Factory as ViewFactory;

class PdfService
{
    protected $view;

    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    public function generateInvoicePdf($invoice, $settings)
    {
        $html = $this->view->make('admin.invoices.email', compact('invoice', 'settings'))->render();
        // echo $html;exit;
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
