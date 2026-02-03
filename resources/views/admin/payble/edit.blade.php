@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Payable</h4>
        <form class="forms-sample" action="{{ route('paybles.update',$payble->id) }}" method="POST" >
            @csrf @method('put')
           
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" id="customer_id">
                    <option value="">Select</option>
                    @foreach($customer as $item)
                        <option value="{{ $item->id }}" {{$payble->customer_id == $item->id ? 'selected' :''}}>{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('customer_id')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

           <div class="row">
            <div class="form-group col-md-6">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Amount" value="{{$payble->amount}}">
               @error('amount')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>

             <div class="form-group col-md-6">
                <label for="due_date">Due Date</label>
                <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" value="{{$payble->due_date}}">
               @error('due_date')  <div class="invalid-feedback">
                    {{$message}}
                </div> @enderror
            </div>
           </div>
            <button type="submit" class="btn btn-primary me-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
        </form>
        </div>
    </div>
    </div>


@endsection