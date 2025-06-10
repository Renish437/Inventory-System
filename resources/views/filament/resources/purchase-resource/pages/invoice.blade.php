<x-filament-panels::page>
    <div class="invoice-box">
        <header class="invoice-header">
            <div class="company-info">
                <h1>INVOICE</h1>
                <p class="company-details">
                    Your Company<br />
                    123 Street Name<br />
                    City, State ZIP<br />
                    your@email.com
                </p>
            </div>
            <div class="invoice-meta">
                <p><strong>Invoice #:</strong> {{ $purchase->invoice_no }}</p>
                <p><strong>Date:</strong> {{ $purchase->purchase_date }}</p>
                <div class="billed-from">
                    <p><strong>Billed From:</strong></p>
                    <p>{{ $purchase->provider?->name }}</p>
                    <p>{{ $purchase->provider?->address }}</p>
                    <p>{{ $purchase->provider?->email }}</p>
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
                            <td>{{ $product->product->name }}</td>
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

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f4f4;
        }

        .invoice-box {
            width: 100%;
            background: #ffffff;
            padding: 50px;
            font-family: 'Inter', 'Arial', sans-serif;
            color: #2d2d2d;
            min-height: 100vh;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .company-info h1 {
            margin: 0 0 20px;
            font-size: 40px;
            font-weight: 800;
            color: #1a202c;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #4a5568;
            padding-bottom: 10px;
        }

        .company-details {
            font-size: 15px;
            line-height: 1.9;
            color: #4a5568;
            margin: 0;
        }

        .invoice-meta {
            font-size: 15px;
            line-height: 1.9;
            color: #4a5568;
            text-align: right;
        }

        .invoice-meta p {
            margin: 6px 0;
        }

        .invoice-meta strong {
            color: #2d2d2d;
            font-weight: 600;
        }

        .billed-from {
            margin-top: 20px;
        }

        .billed-from p {
            margin: 4px 0;
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            background: #ffffff;
        }

        table th,
        table td {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        table th {
            background: #edf2f7;
            font-weight: 700;
            font-size: 13px;
            color: #2d2d2d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            color: #4a5568;
        }

        table tr:hover {
            background: #f7fafc;
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            text-align: center;
        }

        table th:nth-child(4),
        table td:nth-child(4),
        table th:nth-child(5),
        table td:nth-child(5) {
            text-align: right;
        }

        .totals {
            max-width: 400px;
            margin-left: auto;
            padding: 20px;
            background: #f7fafc;
            border-radius: 8px;
            font-size: 15px;
            color: #2d2d2d;
        }

        .totals p {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .totals p span {
            font-weight: 600;
            color: #1a202c;
        }

        .totals .grand-total {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            border-bottom: none;
        }

        .totals .grand-total span {
            font-weight: 800;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #718096;
        }

        .footer-note {
            margin-top: 10px;
            font-size: 12px;
        }

        @media print {
            body {
                background: #ffffff;
                margin: 0;
            }

            .invoice-box {
                padding: 30px;
                box-shadow: none;
                border: none;
            }

            .totals {
                background: none;
                padding: 10px 0;
            }

            .footer {
                position: fixed;
                bottom: 20px;
                width: 100%;
                left: 0;
                right: 0;
            }
        }

        @media (max-width: 768px) {
            .invoice-box {
                padding: 30px;
            }

            .invoice-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .invoice-meta {
                text-align: center;
            }

            .billed-from {
                text-align: center;
            }

            table th,
            table td {
                padding: 10px;
                font-size: 13px;
            }

            .totals {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .company-info h1 {
                font-size: 32px;
            }

            .invoice-meta,
            .company-details {
                font-size: 14px;
            }

            table th,
            table td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</x-filament-panels::page>