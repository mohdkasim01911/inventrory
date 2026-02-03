@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        @include('components.headerButton',['heading' => 'Product','export' => 'products.export','route' => 'products.create'])
   
            {{-- Show entries dropdown --}}
              
        @include('components.showEntry',['perPage' => $perPage, 'route' => 'products.index'])

            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th> {{-- Serial number --}}
                            <th>ID</th>
                            <th>Serial Number</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $number = $startingNumber; // from controller
                        @endphp
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $number++ }}</td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->serial_number }}</td>
                            <td>{{ucfirst($product->name)}}</td>
                            <td>{{ ucfirst($product->category->name)}}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    <i class="mdi mdi-pencil-box-outline"></i>
                                </a>
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $product->id }})">
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
                    {{ $products->links('vendor.pagination.custom-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
