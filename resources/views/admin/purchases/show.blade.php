@extends('layouts.app')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header: Invoice & Company -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="fw-bold">PURCHASE INVOICE</h4>
                    <p class="mb-0">
                        <strong>Invoice No:</strong> {{ $purchase->invoice_no }}<br>
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($purchase->invoice_date)->format('d-M-Y') }}
                    </p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                   <strong>Supplier Details:</strong>
                    {{ $purchase->vendor->name }}<br>
                    <strong>Supplier Details:</strong>
                    {{ $purchase->vendor->address }}<br>
                    GST: {{ $purchase->vendor->gst_number }}
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">GST %</th>
                            <th class="text-end">GST Amt</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">&#8377; {{ number_format($item->price,2) }}</td>
                                <td class="text-end">{{ $item->gst_percent }}%</td>
                                <td class="text-end">&#8377; {{ number_format($item->gst_amount,2) }}</td>
                                <td class="text-end">&#8377; {{ number_format($item->total,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="row mt-4">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-end">&#8377; {{ number_format($purchase->subtotal,2) }}</td>
                        </tr>
                        <tr>
                            <th>GST</th>
                            <td class="text-end">&#8377; {{ number_format($purchase->gst_amount,2) }}</td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td class="text-end fw-bold">&#8377; {{ number_format($purchase->total_amount,2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center mt-4 fst-italic">
                This is a system generated purchase invoice.
            </p>
        </div>
    </div>
</div>

@endsection
