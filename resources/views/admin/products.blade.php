@extends('admin.layouts.app')

@section('title', 'Products')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Products</h1>
        <div>
            @if ($countOutOfStocks > 0)
                <button class="btn btn-danger" data-toggle="modal" data-target="#outOfstockModal">
                    {{ $countOutOfStocks }} Product Out of stock
                </button>
            @endif
            <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Add Product</button>
        </div>
    </div>
@endsection


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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Products List</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-name">Name</th>
                        <th>Category</th>
                        <th class="col-price">Price</th>
                        <th class="col-stock">On sale</th>
                        <th class="col-stock">Stock</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                @if ($product->on_sale)
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="fas fa-times"></i>
                                @endif
                            </td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#viewProductModal{{ $product->id }}"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editProductModal{{ $product->id }}"><i
                                        class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteProductModal{{ $product->id }}"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" data-placeholder="Select a State" id="category"
                                        name="category" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="on_sale" name="on_sale"
                                    value="1">
                                <label class="custom-control-label" for="on_sale">On Sale</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="InputImage">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputImage" name="images[]"
                                        multiple>
                                    <label class="custom-file-label" for="InputImage">Choose files</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="summernote" name="description" rows="3" style="height: 150px;" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Out of Stock Modal --}}
    <div class="modal fade" id="outOfstockModal" tabindex="-1" role="dialog" aria-labelledby="outOfstockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outOfstockModalLabel">Order Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <table id="categoryTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-name">product</th>
                                    <th class="col-actions">status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($outOfStocks as $outOfStock)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $outOfStock->name }}</td>
                                        <td>Out of Stock</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View, Edit and Delete Modals -->
    @foreach ($products as $product)
        <!-- View Product Modal -->
        <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="viewProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form>
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewProductModalLabel{{ $product->id }}">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->category->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            value="{{ $product->price }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            value="{{ $product->stock }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                        {{ $product->on_sale ? 'checked' : '' }} readonly>
                                    <label class="custom-control-label" for="customSwitch1">On Sale</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control summernoteView" id="description" name="description" rows="3" style="height: 150px;" readonly>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="existing_images">Images</label>
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <img src="{{ asset('asset/images/products/' . $image) }}"
                                                    alt="{{ $product->name }}" class="img-fluid">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="" disabled>Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            value="{{ $product->price }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            value="{{ $product->stock }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="on_sale{{ $product->id }}"
                                        name="on_sale" {{ $product->on_sale ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="on_sale{{ $product->id }}">On Sale</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control summernote" id="description{{ $product->id }}" name="description" rows="3"
                                    style="height: 150px;" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="existing_images">Existing Images</label>
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="existing_images[]"
                                                    value="{{ $image }}" checked>
                                                <img src="{{ asset('asset/images/products/' . $image) }}"
                                                    alt="{{ $product->name }}" class="img-fluid">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images">Add New Images</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="InputImage" name="images[]"
                                            multiple>
                                        <label class="custom-file-label" for="InputImage">Choose files</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel{{ $product->id }}">Delete Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the product <strong>{{ $product->name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        $(function() {

            $('#summernote').summernote({
                height: 300, // set default height
                minHeight: 150, // set minimum height of editor
                maxHeight: 500 // set maximum height of editor
            })

            $('.summernote').summernote({
                height: 300, // set default height
                minHeight: 150, // set minimum height of editor
                maxHeight: 500 // set maximum height of editor
            });

            $('.summernoteView').summernote({
                toolbar: [],  // Disable toolbar
                height: 300, // set default height
                minHeight: 150, // set minimum height of editor
                maxHeight: 500, // set maximum height of editor
                disableDragAndDrop: true, // Disable drag and drop
                codeviewFilter: false,
                codeviewIframeFilter: true,
                shortcuts: false,
                airMode: false,
                focus: false
            }).summernote('disable');

            //file input
            bsCustomFileInput.init();

            //table
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Menghindari kolom terakhir (Actions)
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)' // Menghindari kolom terakhir (Actions)
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)' // Menghindari kolom terakhir (Actions)
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)' // Menghindari kolom terakhir (Actions)
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)' // Menghindari kolom terakhir (Actions)
                        }
                    },
                    "colvis"
                ],
                "pageLength": 20
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        });
    </script>
@endpush
