@extends('admin.layouts.app')

@section('title', 'Invoice')

@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Invoice</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            Abdi Jaya, Inc.
                            <small class="float-right">Date: {{ $order->order_date }}</small>
                        </h4>
                    </div>
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        Recipient
                        <address>
                            <strong>{{ $order->address->full_name ?? $order->customer->name }}</strong><br>
                            {{ $order->address->street_address }}<br>
                            {{ $order->address->state }}, {{ $order->address->city }} {{ $order->address->zip_code }}<br>
                            Phone: {{ $order->address->phone }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        Customer
                        <address>
                            <strong>{{ $order->customer->name }}</strong><br>
                            Email: {{ $order->customer->email }}<br>
                            Phone: {{ $order->address->phone }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ $order->id }}</b><br>
                        <br>
                        <b>Order ID:</b> {{ $order->id }}<br>
                        <b>Payment Due:</b> {{ $order->due_date ?? $order->order_date }}<br>
                        <b>Account:</b> 123-45678
                    </div>
                </div>
                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->price * $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Payment row -->
                <div class="row">
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="{{ asset('admin-page/dist/img/credit/visa.png') }}" alt="Visa">
                        <img src="{{ asset('admin-page/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                        <img src="{{ asset('admin-page/dist/img/credit/american-express.png') }}" alt="American Express">
                        <img src="{{ asset('admin-page/dist/img/credit/paypal2.png') }}" alt="Paypal">
                    </div>
                    <div class="col-6">
                        <p class="lead">Amount Due {{ $order->due_date ?? $order->order_date }}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>{{ number_format($order->sub_total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Tax (9.3%):</th>
                                    <td>{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Print and History button row -->
                <div class="row no-print">
                    <div class="col-12">
                        <a href="javascript:window.print();" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <a href="{{ route('admin.history') }}">
                            <button type="button" class="btn btn-success float-right">
                                <i class="far fa-credit-card"></i> History
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
