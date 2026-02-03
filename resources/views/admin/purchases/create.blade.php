@extends('layouts.app')

@section('content')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Purchase</h4>

            <form class="forms-sample" action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <!-- Vendor + Invoice -->
                <div class="form-group">
                    <label for="vendor_id">Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="form-control  @error('vendor_id') is-invalid @enderror">
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                     @error('vendor_id')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="invoice_no">Invoice Number</label>
                        <input type="text" name="invoice_no" class="form-control  @error('invoice_no') is-invalid @enderror" id="invoice_no" placeholder="Invoice Number">
                      @error('invoice_no')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="invoice_date">Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control  @error('invoice_date') is-invalid @enderror" id="invoice_date">
                      @error('invoice_date')
                    <div class="invalid-feedback">
                       {{$message}}
                    </div>
                @enderror
                    </div>
                </div>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>GST %</th>
                                <th>GST Amount</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="productRows">
                            <tr>
                                <td>
                                    <select name="product_id[]" class="form-control product" required>
                                        <option value="">Select</option>
                                        @foreach($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control qty" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" name="price[]" class="form-control price" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" name="gst[]" class="form-control gst" min="0" value="0" required>
                                </td>
                                <td>
                                    <input type="number" name="gst_amt[]" class="form-control gst_amt" value="0" readonly>
                                </td>
                                <td>
                                    <input type="number" name="total[]" class="form-control total" value="0" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeRow">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Add Product</button>
                </div>

                <!-- Totals -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="subtotal">Sub Total</label>
                        <input name="subtotal" id="subtotal" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gstAmount">GST Amount</label>
                        <input name="gst_amount" id="gstAmount" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="grandTotal">Grand Total</label>
                        <input name="grand_total" id="grandTotal" class="form-control" readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary me-2">Save</button>
                <button type="reset" class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>

<!-- JS for Dynamic Row & Calculation -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const productRows = document.getElementById('productRows');
    const addRowBtn = document.getElementById('addRow');

    // Function to calculate totals
    function calculateTotals() {
        let subTotal = 0, gstTotal = 0;

        productRows.querySelectorAll('tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const gst = parseFloat(row.querySelector('.gst').value) || 0;

            const amount = qty * price;
            const gstAmt = (amount * gst) / 100;
            const total = amount + gstAmt;

            row.querySelector('.gst_amt').value = gstAmt.toFixed(2);
            row.querySelector('.total').value = total.toFixed(2);

            subTotal += amount;
            gstTotal += gstAmt;
        });

        document.getElementById('subtotal').value = subTotal.toFixed(2);
        document.getElementById('gstAmount').value = gstTotal.toFixed(2);
        document.getElementById('grandTotal').value = (subTotal + gstTotal).toFixed(2);
    }

    // Initial calculation
    calculateTotals();

    // Recalculate on input change
    productRows.addEventListener('input', calculateTotals);

    // Add new product row
    addRowBtn.addEventListener('click', () => {
        const newRow = productRows.querySelector('tr').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = input.classList.contains('gst') ? '0' : '1');
        newRow.querySelector('.gst_amt').value = '0';
        newRow.querySelector('.total').value = '0';
        productRows.appendChild(newRow);
        calculateTotals();
    });

    // Remove row
    productRows.addEventListener('click', function(e){
        if(e.target.classList.contains('removeRow')){
            const rows = productRows.querySelectorAll('tr');
            if(rows.length > 1){
                e.target.closest('tr').remove();
                calculateTotals();
            } else {
                alert('At least one product row is required.');
            }
        }
    });

});
</script>

@endsection
