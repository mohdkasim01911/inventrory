@extends('layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
    @include('components.headerButton',['heading' => 'Expenses','export' => 'expenses.export','route' => 'expenses.create'])

    @include('components.showEntry',['perPage' => $perPage, 'route' => 'expenses.index'])
    
    <div class="table-responsive">
        <table class="table table-striped text-center">
        <thead>
            <tr>
            <th> # </th>
            <th> Title </th>
            <th> Name </th>
            <th> Amount </th>
            <th> Descriptio </th>
            <th> Action </th>
            </tr>
        </thead>
        @php 
          $i = 1;
        @endphp
        <tbody>
            @foreach($expenses as $item)
               <tr>
                <td class="py-1">
                    {{$i++}}
                </td>
                <td>{{ ucfirst($item->title) }}</td>
                <td>{{ ucfirst($item->name) }}</td>
                <td>{{$item->amount}}</td>
                <td>{{$item->description}}</td>
                  <td class="text-center">
                        <a href="{{ route('expenses.edit',$item->id) }}"
                        class="btn btn-sm btn-warning me-1"
                        title="Edit">
                            <i class="mdi mdi-pencil-box-outline"></i>
                        </a>

                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('expenses.destroy', $item->id) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    class="btn btn-sm btn-danger"
                                    title="Delete"
                                    onclick="confirmDelete({{ $item->id }})">
                                <i class="mdi mdi-delete-forever"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="mt-4">
            {{ $expenses->links('vendor.pagination.custom-bootstrap') }}
        </div>
    </div>
    </div>
</div>
</div>
@endsection