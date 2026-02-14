@extends('layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
    @include('components.headerButton',['heading' => 'Employee','export' => 'employees.export','route' => 'employees.create'])

    @include('components.showEntry',['perPage' => $perPage, 'route' => 'employees.index'])
    
    <div class="table-responsive">
        <table class="table table-striped text-center">
        <thead>
            <tr>
            <th> # </th>
            <th> Name </th>
            <th> Email </th>
            <th> Phone </th>
            <th> Salary </th>
            <th> Due Amount </th>
            <th> Pay Amount </th>
            <th> Action </th>
            </tr>
        </thead>
        @php 
          $i = 1;
        @endphp
        <tbody>
            @foreach($employees as $item)
               <tr>
                <td class="py-1">
                    {{$i++}}
                </td>
                <td>{{ ucfirst($item->name) }}</td>
                <td>{{$item->email ?? 'N/A'}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->salary}}</td>
                <td class="{{ ($item->salary - $item->current_month_amount) < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                    {{ $item->salary - $item->current_month_amount }}
                </td>
                <td>{{$item->current_month_amount ?? '0.00' }}</td>
                  <td class="text-center">
                        <a href="{{ route('employees.edit',$item->id) }}"
                        class="btn btn-sm btn-warning me-1"
                        title="Edit">
                            <i class="mdi mdi-pencil-box-outline"></i>
                        </a>

                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('employees.destroy', $item->id) }}"
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

                        <a href="{{ route('employees.show',$item->id) }}"
                        class="btn btn-sm btn-warning me-1"
                        title="Add Payment">
                            <i class="mdi mdi-arrow-right"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="mt-4">
            {{ $employees->links('vendor.pagination.custom-bootstrap') }}
        </div>
    </div>
    </div>
</div>
</div>
@endsection