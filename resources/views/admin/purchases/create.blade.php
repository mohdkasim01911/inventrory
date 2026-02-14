@extends('layouts.app')

@section('content')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Purchase</h4>

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <!-- Vendor -->
                <div class="form-group">
                    <label>Vendor</label>
                    <select name="vendor_id" class="form-control" required>
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Invoice -->
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Invoice Number</label>
                        <input type="text" name="invoice_no" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control" required>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>GST %</th>
                                <th>GST Amt</th>
                                <th>Total</th>
                                <th>Serial Numbers</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="productRows">
                            <tr>
                                <td class="sr-no text-center">1</td>

                                <td>
                                    <select name="product_id[]" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td><input type="number" name="qty[]" class="form-control qty" value="1"></td>
                                <td><input type="number" name="price[]" class="form-control price" value="1" step="any"></td>
                                <td><input type="number" name="gst[]" class="form-control gst" value="0"></td>

                                

                                <td><input type="number" name="gst_amt[]" class="form-control gst_amt" readonly></td>
                                <td><input type="number" name="total[]" class="form-control total" readonly></td>

                                <!-- SERIAL INPUTS -->
                                <td>
                                    <div class="serial-wrapper">
                                        <div class="d-flex mb-1 serial-row">
                                            <input type="text" name="serial_numbers[0][]" class="form-control me-1" placeholder="Serial No">
                                            <button type="button" class="btn btn-danger btn-sm remove-serial">×</button>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-secondary btn-sm add-serial mt-1">
                                        + Add Serial
                                    </button>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="addRow" class="btn btn-secondary btn-sm">
                        + Add Product
                    </button>
                </div>

                <!-- Totals -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label>Sub Total</label>
                        <input id="subtotal" name="subtotal" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>GST Amount</label>
                        <input id="gstAmount" name="gst_amount" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Grand Total</label>
                        <input id="grandTotal" name="grand_total" class="form-control" readonly>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const productRows = document.getElementById('productRows');
    const addRowBtn = document.getElementById('addRow');

    function updateIndexes() {
        [...productRows.children].forEach((row, index) => {
            row.querySelector('.sr-no').innerText = index + 1;

            row.querySelectorAll('.serial-row input').forEach(input => {
                input.name = `serial_numbers[${index}][]`;
            });
        });
    }

    function calculateTotals() {
        let sub = 0, gstT = 0;

        productRows.querySelectorAll('tr').forEach(row => {
            let qty = +row.querySelector('.qty').value || 0;
            let price = +row.querySelector('.price').value || 0;
            let gst = +row.querySelector('.gst').value || 0;

            let amt = qty * price;
            let gstAmt = amt * gst / 100;

            row.querySelector('.gst_amt').value = gstAmt.toFixed(2);
            row.querySelector('.total').value = (amt + gstAmt).toFixed(2);

            sub += amt;
            gstT += gstAmt;
        });

        subtotal.value = sub.toFixed(2);
        gstAmount.value = gstT.toFixed(2);
        grandTotal.value = (sub + gstT).toFixed(2);
    }

    addRowBtn.addEventListener('click', () => {
        const newRow = productRows.children[0].cloneNode(true);

        newRow.querySelectorAll('input').forEach(i => i.value = '');
        newRow.querySelector('.qty').value = 1;
        newRow.querySelector('.price').value = 1;
        newRow.querySelector('.gst').value = 0;

        newRow.querySelector('.serial-wrapper').innerHTML = `
            <div class="d-flex mb-1 serial-row">
                <input type="text" class="form-control me-1" placeholder="Serial No">
                <button type="button" class="btn btn-danger btn-sm remove-serial">×</button>
            </div>
        `;

        productRows.appendChild(newRow);
        updateIndexes();
        calculateTotals();
    });

    productRows.addEventListener('click', e => {

        if (e.target.classList.contains('removeRow')) {
            if (productRows.children.length > 1) {
                e.target.closest('tr').remove();
                updateIndexes();
                calculateTotals();
            }
        }

        if (e.target.classList.contains('add-serial')) {
            const row = e.target.closest('tr');
            const index = [...productRows.children].indexOf(row);

            const div = document.createElement('div');
            div.className = 'd-flex mb-1 serial-row';
            div.innerHTML = `
                <input type="text" name="serial_numbers[${index}][]" class="form-control me-1" placeholder="Serial No">
                <button type="button" class="btn btn-danger btn-sm remove-serial">×</button>
            `;
            row.querySelector('.serial-wrapper').appendChild(div);
        }

        if (e.target.classList.contains('remove-serial')) {
            const wrapper = e.target.closest('.serial-wrapper');
            if (wrapper.children.length > 1) {
                e.target.closest('.serial-row').remove();
            }
        }
    });

    productRows.addEventListener('input', calculateTotals);

    updateIndexes();
    calculateTotals();
});
</script>

@endsection
