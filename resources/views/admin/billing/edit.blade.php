@extends('layouts.app')



@section('content')



<div class="col-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">



            <h4 class="card-title">Edit Bill #{{ $billing->id }}</h4>



            <form action="{{ route('billings.update', $billing->id) }}" method="POST">

                @csrf

                @method('PUT')



                {{-- Customer --}}

                <div class="row">

                    <div class="form-group col-md-6">

                        <label>Customer</label>

                        <select name="customer_id" class="form-control" required>

                            @foreach($customers as $customer)

                                <option value="{{ $customer->id }}"

                                    {{ $billing->customer_id == $customer->id ? 'selected' : '' }}>

                                    {{ $customer->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group col-md-6">

                        <label>Date</label>

                        <input type="date" name="date" class="form-control" id="date" value="{{$billing->date}}">

                    </div>

                </div>



                {{-- Products --}}

                <div class="table-responsive">

                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th>Qty</th>

                                <th>Amount</th>

                                <th>GST %</th>

                                <th>Serial Numbers</th>

                                <th>Action</th>

                            </tr>

                        </thead>



                        <tbody id="productRows">



                        @foreach($billing->items as $i => $item)

                        <tr>

                            <td>

                                <select name="products[{{ $i }}][product_id]" class="form-control" required>

                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}"

                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>

                                            {{ $product->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </td>



                            <td>

                                <input type="number"

                                       name="products[{{ $i }}][quantity]"

                                       class="form-control"

                                       value="{{ $item->quantity }}">

                            </td>



                            <td>

                                <input type="number"

                                       name="products[{{ $i }}][amount]"

                                       class="form-control"

                                       value="{{ $item->price }}" step="any">

                            </td>



                            <td>

                                <select name="products[{{ $i }}][gst]" class="form-control">

                                    @foreach([0,5,12,18,28] as $gst)

                                        <option value="{{ $gst }}"

                                            {{ $item->gst_percent == $gst ? 'selected' : '' }}>

                                            {{ $gst }}%

                                        </option>

                                    @endforeach

                                </select>

                            </td>



                            {{-- SERIALS --}}

                            <td>

                                <div class="serial-wrapper"

                                     data-name="products[{{ $i }}][serials][]">



                                    @foreach($item->serials as $serial)

                                        <div class="d-flex mb-1">

                                            <input type="text"

                                                   name="products[{{ $i }}][serials][]"

                                                   class="form-control"

                                                   value="{{ $serial->serial_number }}">

                                            <button type="button"

                                                    class="btn btn-sm btn-danger ml-1 remove-serial">×</button>

                                        </div>

                                    @endforeach

                                </div>



                                <button type="button"

                                        class="btn btn-sm btn-primary add-serial mt-1">

                                    + Add Serial

                                </button>

                            </td>



                            <td>

                                <button type="button" class="btn btn-danger removeRow">

                                    Remove

                                </button>

                            </td>

                        </tr>

                        @endforeach



                        </tbody>

                    </table>

                </div>



                <br>



                {{-- OTHER FIELDS --}}

                <div class="row">

                    <div class="col-md-3">

                        <label>Discount</label>

                        <input type="number" name="discount"

                               value="{{ $billing->discount }}"

                               class="form-control">

                    </div>



                    <div class="col-md-3">

                        <label>Cash</label>

                        <input type="number" name="cash"

                               value="{{ $billing->cash }}"

                               class="form-control">

                    </div>



                    <div class="col-md-6">

                        <label>Details</label>

                        <input type="text" name="details"

                               value="{{ $billing->details }}"

                               class="form-control">

                    </div>

                </div>



                <br>



                <button type="submit" class="btn btn-success">

                    Update Invoice

                </button>



                <button type="button" id="addRow"

                        class="btn btn-secondary float-right">

                    Add Product

                </button>



            </form>



        </div>

    </div>

</div>





{{-- ================= JAVASCRIPT ================= --}}

<script>

let index = {{ count($billing->items) }};



// ADD PRODUCT ROW

document.getElementById('addRow').addEventListener('click', function () {



    let row = `

    <tr>

        <td>

            <select name="products[${index}][product_id]" class="form-control" required>

                <option value="">Select</option>

                @foreach($products as $product)

                    <option value="{{ $product->id }}">

                        {{ $product->name }}

                    </option>

                @endforeach

            </select>

        </td>



        <td>

            <input type="number" name="products[${index}][quantity]"

                   class="form-control" value="1">

        </td>



        <td>

            <input type="number" name="products[${index}][amount]"

                   class="form-control" value="1" step="any">

        </td>



        <td>

            <select name="products[${index}][gst]" class="form-control">

                <option value="0">0%</option>

                <option value="5">5%</option>

                <option value="12">12%</option>

                <option value="18" selected>18%</option>

                <option value="28">28%</option>

            </select>

        </td>



        <td>

            <div class="serial-wrapper"

                 data-name="products[${index}][serials][]">

            </div>



            <button type="button"

                    class="btn btn-sm btn-primary add-serial mt-1">

                + Add Serial

            </button>

        </td>



        <td>

            <button type="button"

                    class="btn btn-danger removeRow">

                Remove

            </button>

        </td>

    </tr>`;



    document.getElementById('productRows')

        .insertAdjacentHTML('beforeend', row);



    index++;

});



// REMOVE PRODUCT ROW

document.addEventListener('click', function (e) {

    if (e.target.classList.contains('removeRow')) {

        e.target.closest('tr').remove();

    }

});



// ADD SERIAL

document.addEventListener('click', function (e) {

    if (e.target.classList.contains('add-serial')) {



        let cell = e.target.closest('td');

        let wrapper = cell.querySelector('.serial-wrapper');

        let name = wrapper.dataset.name;



        wrapper.insertAdjacentHTML('beforeend', `

            <div class="d-flex mb-1">

                <input type="text"

                       name="${name}"

                       class="form-control"

                       placeholder="Serial No">

                <button type="button"

                        class="btn btn-sm btn-danger ml-1 remove-serial">

                    ×

                </button>

            </div>

        `);

    }



    // REMOVE SERIAL

    if (e.target.classList.contains('remove-serial')) {

        e.target.closest('.d-flex').remove();

    }

});

</script>



@endsection







