<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        /* === A4 Page Setup === */
        @page {
            size: A4;
            margin: 10mm;
            /* The printer margins */
        }

        /* Global Box Sizing Fix: This ensures padding doesn't add to width */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Arial, sans-serif;
            font-size: 10pt;
            /* Slightly reduced base font for better fit */
        }

        .invoice-wrapper {
            /* CHANGE: Use 100% to fill the @page margin area, not fixed mm */
            width: 95%;
            min-height: 260mm;
            /* A4 height (297) - margins (20) */
            margin: 0 auto;
            padding: 5mm;
            /* Slightly reduced padding to give tables more room */
            border: 1px solid #000;
            background: white;
            line-height: 1.3;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mb-3 {
            margin-bottom: 10px;
        }

        .mb-4 {
            margin-bottom: 15px;
        }

        h3 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* === Borders & Lines === */
        .border-top {
            border-top: 1px solid #000;
        }

        .border-bottom {
            border-bottom: 1px solid #000;
        }

        /* === Table Styling === */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Ensures columns stick to their % widths */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            /* Reduced padding inside cells to prevent overflow */
            vertical-align: middle;
            font-size: 9pt;
            /* Smaller font for table data */
            word-wrap: break-word;
        }

        thead th {
            background: #f0f8ff;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }

        tbody td {
            border-top: none;
            border-bottom: none;
        }

        tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }

        /* === Totals Row === */
        .total-row th {
            background: transparent !important;
            border-top: 1px solid #000 !important;
        }

        /* === Spacing for Empty Rows === */
        .empty-row td {
            /* height: 220px; */
            /* Fixed height for empty rows */
            color: transparent;
        }

        /* === Amount in Words === */
        .amount-words {
            font-weight: bold;
            font-size: 10pt;
            margin: 10px 0;
        }

        /* === Signature Area === */
        .signature-box {
            margin-left: auto;
            margin-top: 30px;
            text-align: center;
            padding-top: 30px;
        }

        .rupee-symbol {
            font-family: 'DejaVu Sans', sans-serif !important;
        }

        /* === Print Styles === */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .invoice-wrapper {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">

        <div class="text-center mb-4">
            <h3>TAX INVOICE</h3>
        </div>

        <div class="mb-3">
            <table width="100%" style="border: none;">
                <tr>
                    <td width="60%" style="border:none; padding:0;">
                        <strong style="font-size: 11pt;">GAURI MOBILES</strong><br>
                        {{$settings['address_line1']}},<br>
                        {{$settings['address_line2']}}<br>
                        Email: {{$settings['store_email']}}<br>
                        Mobile: {{$settings['phone_1']}} | {{$settings['phone_2']}}<br>
                        <strong>GSTIN:</strong> {{$settings['gst_number']}}
                    </td>
                    <td width="40%" class="text-right" style="border:none; padding:0;">
                        <strong>Invoice No:</strong> {{ $invoice[0]->invoice_number }}<br>
                        <strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice[0]->created_at)->format('d-M-Y') }}<br>
                        <strong>Place of Supply:</strong> HARYANA<br>
                        <!-- <strong>EPOS Ref No:</strong> EEC810493217274579 -->
                    </td>
                </tr>
            </table>
        </div>

        <div class="border-top border-bottom mb-3" style="padding: 2px 0;"></div>

        <div class="mb-3">
            <table width="100%" style="border: none;">
                <tr>
                    <td width="60%" style="border:none; padding:0;">
                        <strong>Customer Name:</strong> Mr. {{ $invoice[0]->customer_name }}<br>
                        <strong>Phone:</strong> +91-{{ $invoice[0]->customer_phone }}<br>
                        <strong>Address:</strong> {{ $invoice[0]->billing_address }}
                    </td>
                    <td width="40%" class="text-right" style="border:none; padding:0;">
                        <strong>Member No:</strong> 655310298393120<br>
                        <strong>Salesman:</strong> AMARJEET - 9599969400<br>
                        <strong>Payment:</strong> {{ $invoice[0]->payment_method }} <span class="rupee-symbol">&#8377;</span>{{ number_format($invoice[0]->invoice_total, 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <table class="mb-4">
            <thead>
                <tr>
                    <th width="8%">S.No</th>
                    <th width="25%">Product Name</th>
                    <th width="25%">Description</th>
                    <th width="6%">Qty</th>
                    <th width="10%">Rate</th>
                    <th width="7%">CGST</th>
                    <th width="7%">SGST</th>
                    <th width="12%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($invoice as $index => $item)
                @php $subtotal += $item->total; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fw-medium">{{ $item->product_name }}</td>
                    <td class="text-left">{{ $item->product_description ?? '85171300' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right"><span class="rupee-symbol">&#8377;</span>{{ number_format( ($item->taxable_value ?? $item->price) * 0.82 , 0) }}</td>
                    <td class="text-center">{{ $item->cgst_rate ?? '9' }}%</td>
                    <td class="text-center">{{ $item->sgst_rate ?? '9' }}%</td>
                    <td class="text-right"><span class="rupee-symbol">&#8377;</span>{{ number_format($item->total, 0) }}</td>
                </tr>
                @endforeach

                @php
                $baseHeight = 220;
                $rowHeight = 22;
                $rowNumber = $index ?? 0;
                $calculatedPixels = max(0, $baseHeight - ($rowNumber * $rowHeight));
                $styleAttribute = sprintf('style="height:%spx;"', $calculatedPixels);
                @endphp

                <tr class="empty-row">
                    <td {!! $styleAttribute !!}></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                {{-- Sub Total --}}
                <tr class="total-row">
                    <th colspan="7" class="text-right">Sub Total</th>
                    <th class="text-right" style="border-right: 1px solid #000 !important;"><span class="rupee-symbol">&#8377;</span>{{ number_format($subtotal, 0) }}</th>
                </tr>

                {{-- Discount --}}
                @if(($invoice[0]->discount ?? 0) > 0)
                <tr>
                    <th colspan="7" class="text-right">Discount</th>
                    <th class="text-right" style="border-right: 1px solid #000 !important;">- <span class="rupee-symbol">&#8377;</span>{{ number_format($invoice[0]->discount, 0) }}</th>
                </tr>
                @endif

                {{-- Grand Total --}}
                <tr style="background:#f0f8ff;">
                    <th colspan="7" class="text-right">Grand Total</th>
                    <th class="text-right" style="border-right: 1px solid #000 !important;"><span class="rupee-symbol">&#8377;</span>{{ number_format($invoice[0]->invoice_total, 0) }}</th>
                </tr>
            </tbody>
        </table>

        <div class="amount-words">
            Amount in Words: <span id="words" style="color:#000; font-weight:bold;">{{numberToWords($invoice[0]->invoice_total)}}.</span>
        </div>

        <div class="mb-3">
            <strong>Remarks:</strong> <br>
            <strong>Note:</strong> {{$settings['note']}}<br>
            <strong>Warranty Period:</strong> {{$settings['warranty_months']}}
        </div>

        <div class="text-right mb-4">
            <div class="signature-box"></div>
            <strong>Signature of Dealer / Authorised Representative</strong>
        </div>

        <div class="border-top pt-2" style="font-size:8pt;">
            <strong style="text-decoration:underline;">Terms & Conditions:</strong><br>
            1. {{$settings['tnc1']}}
            2. {{$settings['tnc2']}}
            3. {{$settings['tnc3']}}
            4. {{$settings['tnc4']}}
            5. {{$settings['tnc5']}}
        </div>
    </div>
    <div class="text-center mt-4" style="font-size:9pt;">
        <em>Original for Recipient</em>
    </div>
</body>

</html>