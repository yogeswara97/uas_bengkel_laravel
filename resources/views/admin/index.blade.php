@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $todayOrdersCount }}</h3>
                    <p>Today Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="history" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>${{ number_format($todayRevenue, 2) }}</h3>
                    <p>Today Revenue</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="history" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $thisMonthOrdersCount }}</h3>
                    <p>Orders This Month</p>
                </div>
                <div class="icon">
                    <i class="ion ion-calendar"></i>
                </div>
                <a href="history" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $outOfStock }}</h3>
                    <p>Out of Stock Product</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ $outOfStock > 0 ? 'products' : '#' }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Include chart -->
    <div class="row">
        <div class="col-md-12">
            <!-- Bar chart -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        Bar Chart
                    </h3>

                    <div class="card-tools d-flex">
                        <select id="year-select" class="form-control">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bar-chart" style="height: 200px; color: white"></canvas>
                </div>
                <!-- /.card-body-->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- Popular Products --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-warning card-outline">
                    <h3 class="card-title">Popular Product</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-name">Name</th>
                                <th class="col-price">Price</th>
                                <th class="col-stock">Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($popularProducts as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: Infinity
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('bar-chart').getContext('2d');

            var colors = [
                'rgba(60, 141, 188, 0.5)',
                'rgba(0, 192, 239, 0.5)',
                'rgba(0, 166, 90, 0.5)',
                'rgba(243, 156, 18, 0.5)',
                'rgba(217, 83, 79, 0.5)',
                'rgba(91, 192, 222, 0.5)',
                'rgba(92, 184, 92, 0.5)',
                'rgba(240, 173, 78, 0.5)',
                'rgba(217, 83, 79, 0.5)',
                'rgba(41, 43, 44, 0.5)',
                'rgba(255, 87, 34, 0.5)',
                'rgba(103, 58, 183, 0.5)'
            ];

            var borderColors = [
                'rgba(60, 141, 188, 1)',
                'rgba(0, 192, 239, 1)',
                'rgba(0, 166, 90, 1)',
                'rgba(243, 156, 18, 1)',
                'rgba(217, 83, 79, 1)',
                'rgba(91, 192, 222, 1)',
                'rgba(92, 184, 92, 1)',
                'rgba(240, 173, 78, 1)',
                'rgba(217, 83, 79, 1)',
                'rgba(41, 43, 44, 1)',
                'rgba(255, 87, 34, 1)',
                'rgba(103, 58, 183, 1)'
            ];

            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Orders',
                        data: @json($ordersData),
                        backgroundColor: colors,
                        borderColor: borderColors,
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            document.getElementById('year-select').addEventListener('change', function() {
                window.location.href = '?year=' + this.value;
            });
        });
    </script>
@endpush
