<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-size: 14px;
            color: #333;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
        }

        .invoice-header {
            border-bottom: 2px solid #0d6efd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #0d6efd;
        }

        .company-details {
            text-align: right;
            font-size: 14px;
        }

        .customer-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table th {
            background: #0d6efd;
            color: #fff;
            text-align: center;
        }

        table td {
            vertical-align: middle;
            text-align: center;
        }

        .total-box {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .total-box table td {
            text-align: right;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            background: #e9f2ff;
        }

        .footer-note {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .invoice-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .invoice-table thead {
        background-color: #f1f5f9;
    }

    .invoice-table th {
        border: 1px solid #dee2e6;
        padding: 10px;
        text-align: center;
        font-weight: 600;
        color: #333;
    }

    .invoice-table td {
        border: 1px solid #dee2e6;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
    }

    .invoice-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .invoice-table tbody tr:hover {
        background-color: #f0f7ff;
    }

    .invoice-table .text-start {
        text-align: left;
    }

    .invoice-table .amount {
        text-align: right;
        font-weight: 500;
    }
    </style>
</head>

<body>
<div class="container mt-4">
    <div class="invoice-box">

        <!-- HEADER -->
        <div class="row invoice-header">
            <div class="col-md-6">
                <div class="invoice-title">INVOICE</div>
                <p>Invoice #{{ $billing->id }}</p>
            </div>
            <div class="col-md-6 company-details">
                <strong>Your Company Name</strong><br>
                Address Line 1<br>
                City, State<br>
                Phone: 9999999999
            </div>
        </div>

        <!-- CUSTOMER DETAILS -->
        <div class="row customer-box">
            <div class="col-md-6">
                <strong>Billed To:</strong><br>
                {{ $billing->customer->name }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Date:</strong><br>
                {{ $billing->created_at->format('d-m-Y') }}
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
           <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>GST %</th>
                        <th>GST Amt</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($billing->items as $item)
                    <tr>
                        <td class="text-start">{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="amount">{{ number_format($item->price,2) }}</td>
                        <td>{{ $item->gst_percent }}%</td>
                        <td class="amount">{{ number_format($item->gst_amount,2) }}</td>
                        <td class="amount">{{ number_format($item->total,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <!-- TOTALS -->
        <div class="total-box">
            <table class="table table-bordered">
                <tr>
                    <td>Subtotal</td>
                    <td>{{ number_format($billing->subtotal,2) }}</td>
                </tr>
                <tr>
                    <td>GST</td>
                    <td>{{ number_format($billing->gst_amount,2) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{ number_format($billing->discount,2) }}</td>
                </tr>
                <tr>
                    <td>Cash</td>
                    <td>{{ number_format($billing->cash,2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Total</td>
                    <td>{{ number_format($billing->total_amount,2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Grand Total</td>
                    <td>{{ number_format($billing->total_amount - $billing->discount - $billing->cash,2) }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <!-- FOOTER -->
        <div class="footer-note">
            Thank you for your business! <br>
            This is a system generated invoice.
        </div>

    </div>
</div>
</body>
</html>
