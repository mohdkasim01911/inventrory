@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @include('components.headerButton',['heading' => 'Emis','export' => 'emis.export','route' => false])

            {{-- Show entries dropdown --}}

             @include('components.showEntry',['perPage' => $perPage, 'route' => 'emis.index'])
             
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                             <th>ID</th>
                            <th>User</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Last Paid Date</th>
                            <th>Next Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $number = $startingNumber; // from controller
                        @endphp
                         @foreach($emis as $emi)
                            <tr>
                                <td>{{ $emi->id }}</td>
                                <td>{{ $emi->customer->name }}</td>
                                <td>{{ $emi->total_amount }}</td>
                                <td>{{ $emi->paid_amount }}</td>
                                <td>{{ $emi->due_amount }}</td>
                                <td>{{ $emi->paid_date }}</td>
                                <td>{{ $emi->next_due_date }}</td>
                                <td>{{ $emi->status }}</td>
                                <td>
                                     <a class="btn btn-sm btn-warning" href="{{ route('emis.show', $emi->id) }}"><i class="mdi mdi-eye"></i></a>
                                    <a class="btn btn-sm btn-info" href="{{ route('emis.edit', $emi->id) }}"><i class="mdi mdi-credit-card"></i></a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>

                {{-- Pagination links --}}
                <div class="mt-4">
                    {{ $emis->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
