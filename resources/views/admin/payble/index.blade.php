@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @include('components.headerButton',['heading' => 'Payble','export' => 'paybles.export','route' => 'paybles.create'])

            {{-- Show entries dropdown --}}

            @include('components.showEntry',['perPage' => $perPage, 'route' => 'paybles.index'])


            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th>#</th> {{-- Serial number --}}
                            <th>Customer Name</th>
                            <th>Amount</th>
                            <th>Pay Amount</th>
                            <th>Due Amount</th>
                            <th>Due Date</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $number = $startingNumber; // from controller
                        @endphp
                        @foreach($payble as $item)
                        <tr>
                            <td>{{ $number++ }}</td>
                            <td>{{ $item->customer->name }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->pay_amount }}</td>
                            <td>{{ $item->due_amount }}</td>
                            <td>{{ $item->due_date }}</td>
                            <td>{{ $item->status }}</td>
                            <td>

                                 <a href="{{ route('paybles.check.log', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-eye"></i>
                                </a>


                                <a href="{{ route('paybles.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="mdi mdi-pencil-box-outline"></i>
                                </a>
                                

                                
                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('paybles.destroy', $item->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $item->id }})">
                                        <i class="mdi mdi-delete-forever"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination links --}}
                <div class="mt-4">
                    {{ $payble->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
