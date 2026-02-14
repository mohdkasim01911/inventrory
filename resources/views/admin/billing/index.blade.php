@extends('layouts.app')

@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @include('components.headerButton',['heading' => 'Billing','export' => 'billings.export','route' => 'billings.create'])

            {{-- Show entries dropdown --}}

            @include('components.showEntry',['perPage' => $perPage, 'route' => 'billings.index'])
           

             <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Total Amount</th>
                           <th>GST</th>
                           <th>Sub Total</th>
                           <th>Date</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1; // from controller
                        @endphp
                        @foreach($invoices as $item)
                        <tr>
                             <td>{{ $i++ }}</td>
                             <td>{{ $item->total_amount }}</td>
                             <td>{{ $item->gst_amount }}</td>
                             <td>{{ $item->subtotal }}</td>
                             <td>{{ $item->date }}</td>
                            <td class="text-center">
                                <a href="{{ route('billings.show', $item->id) }}" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                <a href="{{ route('billings.edit',$item->id) }}"
                                    class="btn btn-sm btn-warning me-1"
                                    title="Edit">
                                        <i class="mdi mdi-pencil-box-outline"></i>
                                    </a>

                                <a href="{{ url('billings/'.$item->id.'/download') }}" class="btn btn-sm btn-success"><i class="mdi mdi-download"></i></a>
                                <a href="{{ route('emi.create',$item->id) }}" class="btn btn-sm btn-info"><i class="mdi mdi-credit-card"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination links --}}
                <div class="mt-4">
                    {{ $invoices->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>

         
        </div>
    </div>
</div>

@endsection