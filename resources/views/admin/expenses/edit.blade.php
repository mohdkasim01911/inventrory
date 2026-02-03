@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Edit Expenses</h4>
        <form class="needs-validation" novalidate action="{{ route('expenses.update',$expenses->id) }}" method="POST" >
            @csrf @method('put')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" value="{{ old('title',$expenses->title) }}" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title">
                @error('title')  <div class="invalid-feedback">
                   Title field is required.
                </div> @enderror
            </div>
             <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name',$expenses->name) }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                @error('name')  <div class="invalid-feedback">
                   Name field is required.
                </div> @enderror
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" value="{{ old('amount',$expenses->amount) }}" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Amount">
                @error('amount')  <div class="invalid-feedback">
                    Amount field is required.
                </div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Description">{{$expenses->description}}</textarea>
                @error('description')  <div class="invalid-feedback">
                    Description field is required.
                </div> @enderror
            </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
             <a href="{{route('expenses.index')}}" class="btn btn-light">Cancel</a>
        </form>
        </div>
    </div>
    </div>


@endsection