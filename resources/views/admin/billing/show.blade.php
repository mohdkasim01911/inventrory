@extends('layouts.app')



@section('content')



<div class="col-lg-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">

            <h2 class="mb-3">Invoice #{{ $billing->id }}</h2>

            <div class="card mb-3">

                <div class="card-body">

                    <strong>Customer:</strong> {{ $billing->customer->name }} <br>

                    <strong>Date:</strong> {{ $billing->date }}

                </div>

            </div>



             <div class="table-responsive">

                <table class="table table-striped text-center">

                    <thead>

                        <tr>

                            <th>Product</th>

                            <th>Qty</th>

                            <th>Price</th>

                            <th>GST %</th>

                            <th>GST Amt</th>

                            <th>Total</th>

                            <th>Serial Number</th>

                        </tr>

                    </thead>

                    <tbody>

                       @foreach($billing->items as $item)

                        <tr>

                            <td>{{ $item->product->name }}</td>

                            <td>{{ $item->quantity }}</td>

                            <td>₹ {{ $item->price }}</td>

                            <td>{{ $item->gst_percent }}%</td>

                            <td>₹ {{ $item->gst_amount }}</td>

                            <td>₹ {{ $item->total }}</td>

                            <td>

                                @foreach($item->serials as $serial)

                                  {{$serial->serial_number}}@if($loop->last) @else {{','}} @endif<br/>

                                @endforeach

                            </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>



                 <div class="text-end">

                    <p><strong>Subtotal:</strong> ₹ {{ $billing->subtotal }}</p>

                    <p><strong>GST:</strong> ₹ {{ $billing->gst_amount }}</p>

                    <p><strong>Discount:</strong> ₹ {{ $billing->discount }}</p>

                    <p><strong>Payment Cash:</strong> ₹ {{ $billing->cash }}</p>

                    <h4><strong>Total:</strong> ₹ {{ $billing->total_amount }}</h4>

                    <h4><strong>Grand Total:</strong> ₹ {{ $billing->total_amount - $billing->discount - $billing->cash }}</h4>

                    <p><strong>Details:</strong>{{ $billing->details }}</p>

                </div>



                 <a href="{{ route('billings.index') }}" class="btn btn-secondary">Back</a>



                {{-- Pagination links --}}

                

            </div>



         

        </div>

    </div>

</div>



@endsection