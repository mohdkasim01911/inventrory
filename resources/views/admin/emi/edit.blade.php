@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Pay Emi</h4>
        <h4>Pay EMI #{{ $emi->id }}</h4>
        <p>Due Amount: {{ $emi->due_amount }}</p>
        <form class="forms-sample" action="{{ route('emis.update',$emi->id) }}" method="POST" >
            @csrf @method('put')

         <div class="row">

            <div class="form-group col-md-6">
                 <label for="amount">Pay Amount:</label>
                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{$emi->installment_amount}}" max="{{ $emi->due_amount }}">
             @error('amount')  <div class="invalid-feedback">
                            {{$message}}
                        </div> @enderror
            </div>

            <div class="form-group col-md-6">
                   <label for="date">Paid Date:</label>
                   <input type="date" placeholder="Date" name="paid_date" id="paid_date"  class="form-control @error('paid_date') is-invalid @enderror">
                     @error('paid_date')  <div class="invalid-feedback">
                              {{$message}}
                          </div> @enderror
              </div>

           </div>

            <button type="submit" class="btn btn-primary me-2">Pay</button>
        </form>
        </div>
    </div>
    </div>


@endsection