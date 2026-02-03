@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Employee Expensses</h4>
        <form class="needs-validation" novalidate action="{{ route('employees.show.store') }}" method="POST" >
            @csrf
             <div class="row">
              <input type="hidden" name="employee_id" value="{{$id}}">    
              <div class="form-group col-md-6">
                <label for="amount">Amount</label>
                <input type="text" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Amount">
                @error('amount')  <div class="invalid-feedback">
                   Amount field is required.
                </div> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="details">Details </label>
                <input type="text" name="details" value="{{ old('details') }}" class="form-control @error('details') is-invalid @enderror" id="details" placeholder="Details">
                @error('details')  <div class="invalid-feedback">
                    Details field is required.
                </div> @enderror
            </div>
             </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('employees.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
         <div class="table-responsive">
        <table class="table table-striped text-center">
        <thead>
            <tr>
            <th> # </th>
            <th> Amount </th>
            <th> Details </th>
            <th> Action </th>
            </tr>
        </thead>
        @php 
          $i = 1;
        @endphp
        <tbody>
            @foreach($data as $item)
               <tr>
                <td class="py-1">
                    {{$i++}}
                </td>
                <td>{{ $item->amount }}</td>
                <td>{{$item->details}}</td>

                  <td class="text-center">
                       {{-- <a href="{{ route('employees.edit',$item->id) }}"
                        class="btn btn-sm btn-warning me-1"
                        title="Edit">
                            <i class="mdi mdi-pencil-box-outline"></i>
                        </a> --}}

                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('employees.show.destroy', $item->id) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                             <input type="hidden" name="employee_id" value="{{$id}}"> 

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
        <div class="d-flex justify-content-end">
            Total This Month : {{ $totalAmount }}
        </div>
        <div class="mt-4">
            {{ $data->links('vendor.pagination.custom-bootstrap') }}
        </div>
    </div>
    </div>
    </div>


@endsection