@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Employee</h4>
        <form class="needs-validation" novalidate action="{{ route('employees.store') }}" method="POST" >
            @csrf
        <div class="row"> 
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                @error('name')  <div class="invalid-feedback">
                   {{$message}}
                </div> @enderror
            </div>
        
            <div class="form-group col-md-6">
                <label for="phone">Phone </label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone">
                @error('phone')  <div class="invalid-feedback">
                   {{$message}}
                </div> @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="salary">Salary </label>
                <input type="text" name="salary" value="{{ old('salary') }}" class="form-control @error('salary') is-invalid @enderror" id="salary" placeholder="Salary">
                @error('salary')  <div class="invalid-feedback">
                   {{$message}}
                </div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="email">Email </label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="email">
                @error('email')  <div class="invalid-feedback">
                   {{$message}}
                </div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="address">Address </label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control" id="address" placeholder="Address">
            </div>

            <div class="form-group col-md-6">
                <label for="adhar">Adhar Number</label>
                <input type="text" name="adhar" value="{{ old('adhar') }}" class="form-control" id="adhar" placeholder="Adhar Number">
            </div>

            <div class="form-group col-md-12">
                <label for="pan">PAN Number</label>
                <input type="text" name="pan" value="{{ old('pan') }}" class="form-control" id="pan" placeholder="PAN Number">
            </div>

        </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('employees.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection