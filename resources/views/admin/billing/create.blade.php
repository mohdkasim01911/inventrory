@extends('layouts.app')

@section('content')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add Bill</h4>

            <form action="{{ route('billings.store') }}" method="POST">
                @csrf

                {{-- Customer --}}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Customer</label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">Select</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Products Table --}}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th width="80">Quantity</th>
                                <th width="120">Amount</th>
                                <th width="90">GST %</th>
                                <th>Serial Numbers</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>

                        <tbody id="productRows">

                            {{-- FIRST ROW --}}
                            <tr>
                                <td>
                                    <select name="products[0][product_id]" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (Stock: {{ $product->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number" name="products[0][quantity]"
                                           class="form-control" min="1" value="1" style="width: 100px;">
                                </td>

                                <td>
                                    <input type="number" name="products[0][amount]"
                                           class="form-control" min="1" value="1">
                                </td>

                                <td>
                                    <select name="products[0][gst]" class="form-control">
                                        <option value="0">0%</option>
                                        <option value="5">5%</option>
                                        <option value="12">12%</option>
                                        <option value="18" selected>18%</option>
                                        <option value="28">28%</option>
                                    </select>
                                </td>

                                {{-- SERIAL COLUMN --}}
                                <td>
                                    <div class="serial-wrapper"
                                         data-name="products[0][serials][]">

                                        <div class="d-flex mb-1">
                                            <input type="text"
                                                   name="products[0][serials][]"
                                                   class="form-control"
                                                   placeholder="Serial No">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger ml-1 remove-serial">
                                                ×
                                            </button>
                                        </div>

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
                            </tr>

                        </tbody>
                    </table>
                </div>

                <br>

                {{-- Other Fields --}}
                <div class="row">
                    <div class="col-md-3">
                        <label>Discount</label>
                        <input type="number" name="discount" class="form-control" placeholder="Discount">
                    </div>

                    <div class="col-md-3">
                        <label>Cash</label>
                        <input type="number" name="cash" class="form-control" placeholder="Cash">
                    </div>

                    <div class="col-md-6">
                        <label>Details</label>
                        <input type="text" name="details" class="form-control" placeholder="Details">
                    </div>
                </div>

                <br>

                <button type="submit" class="btn btn-success">
                    Create Invoice
                </button>

                <button type="button"
                        id="addRow"
                        class="btn btn-secondary float-right">
                    Add Product
                </button>

            </form>

        </div>
    </div>
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
let index = 1;

// ADD PRODUCT ROW
document.getElementById('addRow').addEventListener('click', function () {

    let row = `
    <tr>
        <td>
            <select name="products[${index}][product_id]" class="form-control" required>
                <option value="">Select</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="number"
                   name="products[${index}][quantity]"
                   class="form-control" min="1" value="1">
        </td>

        <td>
            <input type="number"
                   name="products[${index}][amount]"
                   class="form-control" min="1" value="1">
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

// ADD SERIAL FIELD
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
                       placeholder="Serial No" >
                <button type="button"
                        class="btn btn-sm btn-danger ml-1 remove-serial">
                    ×
                </button>
            </div>
        `);
    }

    // REMOVE SERIAL FIELD
    if (e.target.classList.contains('remove-serial')) {
        e.target.closest('.d-flex').remove();
    }
});
</script>

@endsection
