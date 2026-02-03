@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
           
             @include('components.headerButton',['heading' => 'Purchase','export' => 'purchases.export','route' => 'purchases.create'])
            

            {{-- Show entries dropdown --}}

             @include('components.showEntry',['perPage' => $perPage, 'route' => 'purchases.index'])

            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Invoice No</th>
                            <th>Vendor</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $number = $startingNumber; // from controller
                        @endphp
                        @foreach($purchases as $item)
                        <tr>
                            <td>{{ $number++ }}</td>
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ $item->vendor->name }}</td>
                            <td>{{ $item->invoice_date }}</td>
                            <td>&#8377; {{ number_format($item->total_amount,2) }}</td>
                            <td>
                                <a href="{{route('purchases.show',$item->id)}}" class="btn btn-sm btn-warning"><i class="mdi mdi-eye"></i></a>
                                <a href="{{url('/purchases/'.$item->id.'/download')}}" class="btn btn-sm btn-success"><i class="mdi mdi-download"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination links --}}
                <div class="mt-4">
                    {{ $purchases->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
