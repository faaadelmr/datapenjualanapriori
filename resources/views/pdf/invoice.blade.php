<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-info div {
            width: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .company-info {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>{{ $sale->invoice_number }}</h2>
    </div>

    <div class="company-info">
        <h3>Your Company Name</h3>
        <p>Your Company Address<br>
        City, State, ZIP Code<br>
        Phone: (123) 456-7890<br>
        Email: info@company.com</p>
    </div>

    <div class="invoice-info">
        <div>
            <h4>Bill To:</h4>
            <p>Customer Name<br>
            Customer Address<br>
            City, State, ZIP Code</p>
        </div>
        <div>
            <h4>Invoice Details:</h4>
            <p><strong>Invoice Number:</strong> {{ $sale->invoice_number }}<br>
            <strong>Date:</strong> {{ $sale->sale_date->format('d/m/Y') }}<br>
            <strong>Due Date:</strong> {{ $sale->sale_date->addDays(30)->format('d/m/Y') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <strong>Total Amount: Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div style="margin-top: 50px;">
        <p><strong>Terms & Conditions:</strong></p>
        <ul>
            <li>Payment is due within 30 days</li>
            <li>Please include invoice number on your payment</li>
            <li>Thank you for your business!</li>
        </ul>
    </div>
</body>
</html>