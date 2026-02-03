@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Edit Category</h4>
        <form class="forms-sample" action="{{ route('categories.update',$category->id) }}" method="POST" >
            @csrf @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" placeholder="Name"  name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name',$category->name) }}">
             <div class="invalid-feedback">
                    Category name is required.
             </div>
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('categories.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection