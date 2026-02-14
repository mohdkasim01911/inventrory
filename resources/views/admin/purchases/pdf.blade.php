<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Purchase Invoice</title>
<style>
    /* Reset and base */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        color: #333;
        margin: 0;
        padding: 20px;
        background-color: #f9fafb;
    }

    .invoice-container {
        max-width: 800px;
        margin: auto;
        background: #fff;
        padding: 30px 40px;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        border-bottom: 3px solid #007bff;
        padding-bottom: 12px;
    }

    .header-left {
        max-width: 60%;
    }

    .invoice-title {
        font-size: 28px;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .invoice-info strong {
        font-weight: 600;
    }

    .header-right {
        text-align: right;
        font-size: 14px;
        line-height: 1.5;
        color: #444;
    }

    /* Vendor */
    .vendor-box {
        background-color: #f1f5f9;
        padding: 18px 22px;
        border-radius: 6px;
        margin-bottom: 30px;
        font-size: 14px;
        color: #222;
    }

    .vendor-box strong {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 14px;
        min-width: 600px; /* prevent excessive shrinking */
    }

    thead {
        background-color: #007bff;
        color: #fff;
        text-align: center;
    }

    thead th {
        padding: 12px 10px;
        font-weight: 600;
        border: 1px solid #0056b3;
    }

    tbody td {
        padding: 10px 8px;
        border: 1px solid #ddd;
        vertical-align: middle;
        text-align: center;
    }

    tbody tr:nth-child(even) {
        background-color: #f9fbfd;
    }

    tbody tr:hover {
        background-color: #e6f0ff;
    }

    tbody td.product-name {
        text-align: left;
    }

    tbody td.qty,
    tbody td.price,
    tbody td.gst-percent,
    tbody td.gst-amt,
    tbody td.total {
        white-space: nowrap;
    }

    /* Totals */
    .totals {
        max-width: 320px;
        margin-left: auto;
        border-top: 2px solid #ddd;
    }

    .totals table {
        width: 100%;
        border-collapse: collapse;
    }

    .totals td {
        padding: 12px 10px;
        font-weight: 600;
        border: 1px solid #ddd;
        text-align: right;
    }

    .totals tr:last-child td {
        background-color: #e9f2ff;
        font-size: 18px;
        font-weight: 700;
        border-color: #007bff;
    }

    /* Footer */
    .footer {
        margin-top: 40px;
        font-size: 13px;
        text-align: center;
        color: #666;
        font-style: italic;
        user-select: none;
    }

    /* Responsive */
    @media (max-width: 720px) {
        .invoice-container {
            padding: 20px;
        }

        table {
            min-width: auto;
            font-size: 13px;
        }

        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .header-right {
            text-align: left;
        }

        .totals {
            max-width: 100%;
            margin-left: 0;
        }
    }
</style>
</head>
<body>

<div class="invoice-container">
    <div class="header">
        <div class="header-left">
            <div class="invoice-title">PURCHASE INVOICE</div>
            <div class="invoice-info">
                <div><strong>Invoice No:</strong> {{ $purchase->invoice_no }}</div>
                <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($purchase->invoice_date)->format('d-M-Y') }}</div>
            </div>
        </div>
    </div>

    <div class="vendor-box">
        <strong>Supplier Details:</strong>
        <div>{{ $purchase->vendor->name }}</div>
        <div>{{ $purchase->vendor->address }}</div>
        <div>GST: {{ $purchase->vendor->gst_number }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th class="product-name">Product</th>
                <th class="qty">Qty</th>
                <th class="price">Price</th>
                <th class="gst-percent">GST %</th>
                <th class="gst-amt">GST Amt</th>
                <th class="total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="product-name">{{ $item->product->name }}</td>
                <td class="qty">{{ $item->quantity }}</td>
                <td class="price">{{ number_format($item->price, 2) }}</td>
                <td class="gst-percent">{{ $item->gst_percent }}%</td>
                <td class="gst-amt">{{ number_format($item->gst_amount, 2) }}</td>
                <td class="total">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal</td>
                <td>{{ number_format($purchase->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>GST</td>
                <td>{{ number_format($purchase->gst_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Grand Total</td>
                <td>{{ number_format($purchase->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        This is a system generated purchase invoice.
    </div>
</div>

</body>
</html>
