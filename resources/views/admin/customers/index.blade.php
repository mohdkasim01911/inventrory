@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

       @include('components.headerButton',['heading' => 'Customer','export' => 'customers.export','route' => 'customers.create'])

            {{-- Show entries dropdown --}}

        @include('components.showEntry',['perPage' => $perPage, 'route' => 'customers.index'])
           
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Contact</th>
                           <th>Email</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1; // from controller
                        @endphp
                        @foreach($customers as $customer)
                        <tr>
                             <td>{{ $i++ }}</td>
                             <td>{{ ucfirst($customer->name) }}</td>
                             <td>{{ $customer->contact }}</td>
                             <td>{{ $customer->email }}</td>
                             <td class="text-center">
                                <a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil-box-outline"></i></a>
                                
                                    <form id="delete-form-{{ $customer->id }}"
                                    action="{{ route('customers.destroy', $customer->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $customer->id }})">
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
                    {{ $customers->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
