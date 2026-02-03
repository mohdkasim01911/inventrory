@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Category</h4>
        <form class="needs-validation" novalidate action="{{ route('categories.store') }}" method="POST" >
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" required>
                @error('name')  <div class="invalid-feedback">
                    Category name is required.
                </div> @enderror
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('categories.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection