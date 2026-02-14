@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Suppliers</h4>
        <form class="forms-sample" action="{{ route('suppliers.store') }}" method="POST" >
            @csrf
           
        <div class="row">

            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                @error('name') <div class="invalid-feedback">{{$message}}</div> @enderror  
            </div>

            <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" name="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone">
                @error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror  
            </div>

            <div class="form-group col-md-6">
                <label for="gst_number">GST Nuber</label>
                <input type="text" name="gst_number" value="{{old('gst_number')}}" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" placeholder="GST Nuber">
               @error('gst_number') <div class="invalid-feedback">{{$message}}</div> @enderror  
            </div>

            <div class="form-group col-md-6">
                <label for="adhar">Adhar Number</label>
                <input type="text" value="{{old('adhar')}}" name="adhar" class="form-control" placeholder="Adhar Number">
            </div>

            <div class="form-group col-md-6">
                <label for="pan">PAN Number</label>
                <input type="text" name="pan" value="{{old('pan')}}" class="form-control" id="pan" placeholder="PAN Number"> 
            </div>

            <div class="form-group col-md-6">
                <label for="address">Address</label>
                <input type="text" name="address" value="{{old('address')}}" class="form-control" id="address" placeholder="Address">  
            </div>
        </div>
           

            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('suppliers.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection