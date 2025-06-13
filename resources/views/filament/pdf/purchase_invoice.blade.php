<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $purchase->invoice_no }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
            font-size: 12px;
            line-height: 1.5;
        }

        .invoice-box {
            width: 100%;
            max-width: 190mm; /* Slightly less than A4 width (210mm) to account for margins */
            margin: 10mm auto;
            padding: 10mm;
            background: #ffffff;
            page-break-inside: auto;
        }

        .invoice-header {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .header-row {
            width: 100%;
        }

        .company-info, .invoice-meta {
            display: inline-block;
            vertical-align: top;
            width: 100%;
        }

        .company-info {
            margin-right: 4%;
        }

        .company-info h1 {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #333333;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .company-details, .invoice-meta p {
            font-size: 12px;
            line-height: 1.6;
            color: #555555;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta p {
            margin: 3px 0;
        }

        .invoice-meta strong {
            color: #000000;
            font-weight: bold;
        }

        .billed-from {
            margin-top: 10px;
        }

        .billed-from p {
            margin: 3px 0;
        }

        .table-container {
            margin-bottom: 20px;
            page-break-inside: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: fixed;
        }

        table th, table td {
            padding: 6px 8px;
            border-bottom: 1px solid #dddddd;
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        table th {
            background: #f5f5f5;
            font-weight: bold;
            font-size: 10px;
            color: #333333;
            text-transform: uppercase;
        }

        table td {
            color: #555555;
        }

        table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        table th:nth-child(1), table td:nth-child(1) { width: 10%; } /* # */
        table th:nth-child(2), table td:nth-child(2) { width: 40%; } /* Description */
        table th:nth-child(3), table td:nth-child(3) { width: 15%; text-align: center; } /* Quantity */
        table th:nth-child(4), table td:nth-child(4) { width: 15%; text-align: right; } /* Unit Price */
        table th:nth-child(5), table td:nth-child(5) { width: 20%; text-align: right; } /* Total */

        .totals {
            max-width: 200px;
            margin-left: auto;
            padding: 10px;
            font-size: 12px;
            color: #333333;
            page-break-inside: avoid;
        }

        .totals p {
            display: block;
            margin: 5px 0;
            padding: 5px 0;
            border-bottom: 1px solid #dddddd;
        }

        .totals p span {
            font-weight: bold;
            color: #000000;
            display: inline-block;
            width: 70px;
        }

        .totals .grand-total {
            font-size: 14px;
            font-weight: bold;
            color: #000000;
            border-bottom: none;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #dddddd;
            font-size: 10px;
            color: #777777;
            page-break-inside: avoid;
        }

        .footer-note {
            margin-top: 5px;
            font-size: 9px;
        }

        @media print {
            body {
                margin: 0;
                background: #ffffff;
            }

            .invoice-box {
                margin: 5mm auto;
                padding: 5mm;
                box-shadow: none;
                border: none;
            }

            .table-container {
                overflow-x: hidden;
            }

            table {
                width: 100%;
            }

            .totals {
                background: none;
                padding: 5px 0;
            }

            .footer {
                position: static;
                margin-top: 15px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .invoice-box {
                padding: 5mm;
                margin: 2mm;
            }

            .company-info, .invoice-meta {
                width: 100%;
                text-align: center;
            }

            .invoice-meta {
                margin-top: 10px;
            }

            table th, table td {
                padding: 4px 6px;
                font-size: 10px;
            }

            .totals {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <header class="invoice-header">
            <div class="header-row">
                <div class="company-info">
                    <h1>INVOICE</h1>
                    <p class="company-details">
                         {{ $settings['Tenant Name'] }}<br />
                    {{ $settings['Address'] }}<br />
                    {{ $settings['City'] }}, {{ $settings['Zip'] }}<br />
                    {{ $settings['Email'] }}
                    </p>
                </div>
                <div class="invoice-meta">
                    <p><strong>Invoice #:</strong> {{ $purchase->invoice_no }}</p>
                    <p><strong>Date:</strong> {{ $purchase->purchase_date }}</p>
                    <div class="billed-from">
                        <p><strong>Billed From:</strong></p>
                        <p>{{ $purchase->provider?->name ?? 'N/A' }}</p>
                        <p>{{ $purchase->provider?->address ?? 'N/A' }}</p>
                        <p>{{ $purchase->provider?->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product->name ?? 'N/A' }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ number_format($product->price, 2) }}</td>
                            <td>{{ number_format($product->price * $product->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <p><span>Subtotal:</span> {{ number_format($purchase->total, 2) }}</p>
            <p><span>Discount:</span> {{ number_format($purchase->discount, 2) }}</p>
            <p class="grand-total"><span>Total:</span> {{ number_format($purchase->total - $purchase->discount, 2) }}</p>
        </div>

        <footer class="footer">
            <p>Thank you for your business!</p>
            <p class="footer-note">For inquiries, contact us at your@email.com or call (123) 456-7890.</p>
        </footer>
    </div>
</body>
</html>