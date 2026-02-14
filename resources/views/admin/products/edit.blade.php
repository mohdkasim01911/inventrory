@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Edit Product</h4>
        <form class="forms-sample" action="{{ route('products.update',$product->id) }}" method="POST" >
            @csrf @method('put')

             <div class="row">
           
            <div class="form-group col-md-6">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id" >
                    <option value="">Select</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{$product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{$product->name}}" >
                @error('name')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="ampere">Ampere</label>
                <input type="text" name="ampere" value="{{old('ampere',$product->ampere)}}" class="form-control @error('ampere') is-invalid @enderror" id="ampere" placeholder="Ampere">
            </div>

            <div class="form-group col-md-6">
                <label for="date">Date</label>
                <input type="date" name="date" value="{{old('date',$product->date)}}" class="form-control @error('date') is-invalid @enderror" id="date">
            </div>

             <div class="form-group col-md-12">
                <label for="name">Month</label>
                <input type="number" name="month" value="{{old('month',$product->month)}}" class="form-control @error('month') is-invalid @enderror" id="month" placeholder="Month">
                @error('month')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

        </div>

        {{--     <div class="form-group col-md-6">
                <label for="serial_number">Serial Number</label>
                <input type="text" name="serial_number" class="form-control" id="serial_number" placeholder="Serial Number" value="{{$product->serial_number}}" >
             
            </div>
         

             <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Price" value="{{$product->price}}" >
                @error('price')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div>

             <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" placeholder="Stock" value="{{$product->stock}}">
               @error('stock')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
            </div> --}}

            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <a href="{{route('products.index')}}" class="btn btn-light">Cancel</a>


        </form>
        </div>
    </div>
    </div>


@endsection