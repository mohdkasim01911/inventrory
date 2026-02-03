@extends('layouts.app')

@section('content')

  <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title">Add Emi</h4>
        <form class="forms-sample" action="{{ route('emis.store') }}" method="POST" >
            @csrf

            <input type="hidden" name="billing_id" value="{{ $sale->id }}">

            <div class="form-group">
                 <label for="installments">Installments:</label>
                 <input type="number" placeholder="Installments" name="installments" id="installments" min="1" class="form-control @error('installments') is-invalid @enderror">
                   @error('installments')  <div class="invalid-feedback">
                            {{$message}}
                        </div> @enderror
            </div>

            <button type="submit" class="btn btn-primary me-2">Submit</button>
        </form>
        </div>
    </div>
    </div>


@endsection