@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Customer</h4>
        <form class="forms-sample" action="{{ route('customers.store') }}" method="POST" >
            @csrf
           
        <div class="row">
            <div class="form-group col-md-12">
                <label for="name">Name</label>
                <input type="text" value="{{old('name')}}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">  
                @error('name')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="contact">Contact</label>
                <input type="text" value="{{old('contact')}}" name="contact" class="form-control @error('contact') is-invalid @enderror" id="contact" placeholder="Contact">
                  @error('contact')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="text" value="{{old('email')}}" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                @error('email')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="adhar">Adhar Number</label>
                <input type="text" value="{{old('adhar')}}" name="adhar" class="form-control" id="adhar" placeholder="Adhar Number">
            </div>

            <div class="form-group col-md-6">
                <label for="pan">PAN Number</label>
                <input type="text" value="{{old('pan')}}" name="pan" class="form-control" id="pan" placeholder="PAN Number">
            </div>
        </div>   

            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
    </div>


@endsection