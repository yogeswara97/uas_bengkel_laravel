@extends('admin.layouts.app')

@section('title', 'Add Order')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Add Order</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <h1 class="float-sm-right">{{ date('Y-m-d') }}</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-name">Name</th>
                                <th class="col-price">Price</th>
                                <th class="col-stock">Stock</th>
                                <th class="col-action">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="d-flex justify-content-center">
                                        <button type="button" id="add-btn-{{ $product->id }}"
                                            class="btn btn-primary btn-sm"
                                            onclick="addProductToOrder({{ $product->id }}, '{{ $product->name }}', {{ $product->price }},{{ $product->stock }});">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Order</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customer_name">Customer Name</label>
                            <select class="form-control select2" id="customer_name" name="customer_id" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                @endforeach
                            </select>


                        </div>
                        <div class="form-group">
                            <label for="order_date">Order Date</label>
                            <input type="date" class="form-control" id="order_date" name="order_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div id="orderItems">
                            <!-- Order items will be added here dynamically -->
                            <table id="orderItemsTable" class="table table-bordered table-hover">
                                <thead id="orderItemsHeader" style="display: none">
                                    <tr>
                                        <th style="width: 50%">Name</th>
                                        <th style="width: 25%">Price</th>
                                        <th style="width: 25%">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic order items will be appended here -->
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="order_items" id="orderItemsInput">
                        <input type="hidden" name="sub_total_price" id="subTotalPriceInput">
                        <input type="hidden" name="tax" id="taxInput">
                        <input type="hidden" name="total_price" id="totalPriceInput">
                    </div>
                </div>

                <!-- Address Modal -->
                <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addressModalLabel">Enter Recipient Name</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="street_address">Street Address</label>
                                    <input type="text" class="form-control" id="street_address" name="street_address">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state"name="state">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zip_code">Zip Code</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="price-details mb-3 mb-md-0">
                                <p class="mb-1">Sub Total: $ <span id="subTotalPrice">0.00</span></p>
                                <p class="mb-1">Tax(0,93%): $ <span id="tax">0.00</span></p>
                                <h5 class="mb-0">Total: $ <span id="totalPrice">0.00</span></h5>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="showAddressModal()">Submit
                                Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="outOfStockModal" tabindex="-1" role="dialog" aria-labelledby="outOfStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outOfStockModalLabel">Alret</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    The selected product is out of stock.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="noProductsModal" tabindex="-1" role="dialog" aria-labelledby="outOfStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outOfStockModalLabel">Alret</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pelase Select the product
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        function showAddressModal() {
            let orderItemsTable = document.querySelector('#orderItemsTable tbody');
            if (orderItemsTable.children.length === 0) {
                $('#noProductsModal').modal('show');
            } else {
                $('#addressModal').modal('show');
            }
        }

        function addProductToOrder(productId, productName, productPrice, productStock) {
            let orderItemsTable = document.querySelector('#orderItemsTable tbody');
            let existingRow = document.getElementById('product-row-' + productId);

            if (productStock <= 0) {
                $('#outOfStockModal').modal('show');
                return;
            }

            if (existingRow) {
                let quantityElement = existingRow.querySelector('.quantity');
                let totalPriceElement = existingRow.querySelector('.total-price');
                let quantity = parseInt(quantityElement.innerText) + 1;
                quantityElement.innerText = quantity;
                totalPriceElement.innerText = (productPrice * quantity).toFixed(2);
            } else {
                let newRow = document.createElement('tr');
                newRow.setAttribute('id', 'product-row-' + productId);
                newRow.innerHTML = `
                    <td>${productName}</td>
                    <td class="total-price">${productPrice.toFixed(2)}</td>
                    <td class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="decrementQuantity(this, ${productPrice},${productId})"><i class="fas fa-minus"></i></button>
                        <h4 class="mb-0 quantity">1</h4>
                        <button type="button" class="btn btn-primary btn-sm" onclick="incrementQuantity(this, ${productPrice},${productStock})"><i class="fas fa-plus"></i></button>
                    </td>
                `;
                orderItemsTable.appendChild(newRow);
                document.getElementById('add-btn-' + productId).disabled = true;
            }

            updateTotalPrice();
            updateOrderItemsInput();
            toggleOrderItemsHeader();
        }

        function incrementQuantity(button, productPrice, productStock) {
            let quantityElement = button.previousElementSibling;
            let totalPriceElement = button.parentElement.previousElementSibling;
            let quantity = parseInt(quantityElement.innerText);
            if (quantity < productStock) {
                quantityElement.innerText = quantity + 1;
                totalPriceElement.innerText = (productPrice * (quantity + 1)).toFixed(2);
            }

            updateTotalPrice();
            updateOrderItemsInput();
            toggleOrderItemsHeader();
        }

        function decrementQuantity(button, productPrice, productId) {
            let quantityElement = button.nextElementSibling;
            let totalPriceElement = button.parentElement.previousElementSibling;
            let quantity = parseInt(quantityElement.innerText);
            if (quantity > 1) {
                quantityElement.innerText = quantity - 1;
                totalPriceElement.innerText = (productPrice * (quantity - 1)).toFixed(2);
            } else {
                let row = button.closest('tr');
                row.remove();
                document.getElementById('add-btn-' + productId).disabled = false;
            }

            updateTotalPrice();
            updateOrderItemsInput();
            toggleOrderItemsHeader();
        }

        function updateTotalPrice() {
            let subTotalPrice = 0;
            const taxRate = 0.0093;

            document.querySelectorAll('.total-price').forEach(function(element) {
                subTotalPrice += parseFloat(element.innerText);
            });

            let tax = subTotalPrice * taxRate;
            let totalPrice = subTotalPrice + tax;

            document.getElementById('subTotalPrice').innerText = subTotalPrice.toFixed(2);
            document.getElementById('tax').innerText = tax.toFixed(2);
            document.getElementById('totalPrice').innerText = totalPrice.toFixed(2);
            document.getElementById('subTotalPriceInput').value = subTotalPrice.toFixed(2);
            document.getElementById('taxInput').value = tax.toFixed(2);
            document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);
        }

        function updateOrderItemsInput() {
            let orderItems = [];
            document.querySelectorAll('#orderItemsTable tbody tr').forEach(function(row) {
                let productId = row.id.split('-')[2];
                let quantity = parseInt(row.querySelector('.quantity').innerText);
                let price = parseFloat(row.querySelector('.total-price').innerText) / quantity;
                orderItems.push({
                    product_id: productId,
                    quantity: quantity,
                    price: price.toFixed(2) * quantity,
                });
            });

            document.getElementById('orderItemsInput').value = JSON.stringify(orderItems);
            console.log(document.getElementById('orderItemsInput').value);
        }

        function toggleOrderItemsHeader() {
            let orderItemsTable = document.querySelector('#orderItemsTable tbody')
            let orderItemsHeader = document.querySelector('#orderItemsHeader');

            if (orderItemsTable.children.length > 0) {
                orderItemsHeader.style.display = 'table-header-group';
            } else {
                orderItemsHeader.style.display = 'none'
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleOrderItemsHeader();
        });
    </script>

@stop

@push('scripts')
    <script>
        $(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4',
            });
            $('.select2-modal').select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: Infinity
            });

            function showAddressModal() {
                $('#addressModal').modal('show');
            }

            //table
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "pageLength": 20
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });


        });
    </script>
@endpush
