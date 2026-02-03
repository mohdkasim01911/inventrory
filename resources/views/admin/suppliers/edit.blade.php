@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Suppliers</h4>
        <form class="forms-sample" action="{{ route('suppliers.update',$supplier->id) }}" method="POST" >
            @csrf @method('put')
           
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{$supplier->name}}">  
                @error('name') <div class="invalid-feedback">{{$message}}</div> @enderror 
            </div>

            <div class="form-group ">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Phone" value="{{$supplier->phone}}">
                @error('phone') <div class="invalid-feedback">{{$message}}</div> @enderror 
            </div>

             <div class="form-group ">
                <label for="gst_number">GST Number</label>
                <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" placeholder="GST Number" value="{{$supplier->gst_number}}">
               @error('gst_number') <div class="invalid-feedback">{{$message}}</div> @enderror 
            </div>

             <div class="form-group ">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address" value="{{$supplier->address}}">
                @error('address') <div class="invalid-feedback">{{$message}}</div> @enderror 
            </div>

           

            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <a href="{{route('suppliers.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection