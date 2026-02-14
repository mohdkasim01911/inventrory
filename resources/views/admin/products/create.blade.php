@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Product</h4>
        <form class="needs-validation" action="{{ route('products.store') }}" method="POST" >
            @csrf

             <div class="row">
           
            <div class="form-group col-md-6">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                    <option value="">--Select--</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
                
            </div>

          
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                @error('name')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="ampere">Ampere</label>
                <input type="text" name="ampere" value="{{old('ampere')}}" class="form-control @error('ampere') is-invalid @enderror" id="ampere" placeholder="Ampere">
            </div>

            <div class="form-group col-md-6">
                <label for="date">Date</label>
                <input type="date" name="date" value="{{old('date')}}" class="form-control @error('date') is-invalid @enderror" id="date">
            </div>

             <div class="form-group col-md-12">
                <label for="name">Month</label>
                <input type="number" name="month" value="{{old('month')}}" class="form-control @error('month') is-invalid @enderror" id="month" placeholder="Month">
                @error('month')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

             </div>


          {{--   <div class="form-group col-md-6">
                <label for="serial_number">Serial Number</label>
                <input type="text" name="serial_number" value="{{old('serial_number')}}" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" placeholder="Serial Number" >
                @error('serial_number')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>
          

             <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" value="{{old('price')}}" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Price">
                @error('price')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

             <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" name="stock" value="{{old('stock')}}" class="form-control @error('stock') is-invalid @enderror" id="stock" placeholder="Stock">
                @error('stock')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>   --}}

            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <a href="{{route('products.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection