@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Customer</h4>
        <form class="forms-sample" action="{{ route('customers.store') }}" method="POST" >
            @csrf
           
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">  
                @error('name')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>
            <div class="form-group ">
                <label for="contact">Contact</label>
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" id="contact" placeholder="Contact">
                  @error('contact')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

             <div class="form-group ">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                  @error('email')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>
           

            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
    </div>


@endsection