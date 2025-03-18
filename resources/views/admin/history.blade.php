@extends('admin.layouts.app')

@section('title','Order History')

@section('content-header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Order History</h1>
        <form action="{{ route('admin.history') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label for="start_date" class="mr-2">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control mr-2" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date" class="mr-2">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control mr-2" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" id="clear-filter" class="btn btn-danger ml-2">Clear Filter</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">History</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-name">Customer Name</th>
                        <th class="col-actions">Total Price</th>
                        <th class="col-actions">Date</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" data-toggle="modal"
                                    data-target="#editorderModal{{ $order->id }}"><i
                                        class="fas fa-eye"></i></button>
                                <a href="{{ route('admin.invoice.show', $order->id) }}">
                                    <button class="btn btn-success btn-sm" ><i class="fas fa-file-invoice"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($orders as $order)
        <!-- Order Item Modal -->
        <div class="modal fade" id="editorderModal{{ $order->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editorderModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editorderModalLabel{{ $order->id }}">Order Item</h5>
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
                                        <th class="col-name">Product</th>
                                        <th class="col-actions">Quantity</th>
                                        <th class="col-actions">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
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
    @endforeach

    <script>
        document.getElementById('clear-filter').addEventListener('click', function() {
            window.location.href = '{{ route("admin.history") }}';
        });
    </script>
@endsection

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

            //table
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [[2, "desc"]],
                "buttons": [
                    {
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
