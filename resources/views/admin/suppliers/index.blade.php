@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            @include('components.headerButton',['heading' => 'Supplier','export' => 'suppliers.export','route' => 'suppliers.create'])
             
            {{-- Show entries dropdown --}}
            
             @include('components.showEntry',['perPage' => $perPage, 'route' => 'suppliers.index'])


            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Phone</th>
                           <th>GST Number</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1; // from controller
                        @endphp
                        @foreach($suppliers as $supplier)
                        <tr>
                             <td>{{ $i++ }}</td>
                             <td>{{ ucfirst($supplier->name) }}</td>
                             <td>{{ $supplier->phone }}</td>
                             <td>{{ $supplier->gst_number }}</td>
                             <td class="text-center">
                                <a href="{{ route('suppliers.edit',$supplier->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil-box-outline"></i></a>
                                
                                    <form id="delete-form-{{ $supplier->id }}"
                                    action="{{ route('suppliers.destroy', $supplier->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $supplier->id }})">
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
                    {{ $suppliers->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
