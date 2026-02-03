@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Employee</h4>
        <form class="needs-validation" novalidate action="{{ route('employees.update',$employee->id) }}" method="POST" >
            @csrf @method('put')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name',$employee->name) }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                @error('name')  <div class="invalid-feedback">
                   Name field is required.
                </div> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email </label>
                <input type="text" name="email" value="{{ old('email',$employee->email) }}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email">
                @error('email')  <div class="invalid-feedback">
                    Email field is required.
                </div> @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone </label>
                <input type="text" name="phone" value="{{ old('phone',$employee->phone) }}" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone">
                @error('phone')  <div class="invalid-feedback">
                    Phone field is required.
                </div> @enderror
            </div>
             <div class="form-group">
                <label for="salary">Salary </label>
                <input type="text" name="salary" value="{{ old('salary',$employee->salary) }}" class="form-control @error('salary') is-invalid @enderror" id="salary" placeholder="Salary">
                @error('salary')  <div class="invalid-feedback">
                    Salary field is required.
                </div> @enderror
            </div>
             <div class="form-group">
                <label for="address">Address </label>
                <input type="text" name="address" value="{{ old('address',$employee->address) }}" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address">
                @error('address')  <div class="invalid-feedback">
                    Address field is required.
                </div> @enderror
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('employees.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection