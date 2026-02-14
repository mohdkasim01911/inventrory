@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Edit Customer</h4>
        <form class="forms-sample" action="{{ route('customers.update',$customer->id) }}" method="POST" >
            @csrf @method('put')

        <div class="row">
           
            <div class="form-group col-md-12">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name',$customer->name)}}">  
                @error('name')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="contact">Contact</label>
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" id="contact" placeholder="Contact" value="{{old('contact',$customer->contact)}}">
                 @error('contact')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email',$customer->email)}}">
                 @error('email')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="adhar">Adhar Number</label>
                <input type="text" name="adhar" class="form-control" id="adhar" placeholder="Adhar Number" value="{{old('adhar',$customer->adhar)}}">
            </div>

            <div class="form-group col-md-6">
                <label for="pan">PAN Number</label>
                <input type="text" name="pan" class="form-control" id="pan" placeholder="PAN Number" value="{{old('pan',$customer->pan)}}">
            </div>
        </div>      
     
            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
    </div>


@endsection