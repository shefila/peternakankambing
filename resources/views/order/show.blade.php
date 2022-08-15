@extends('layouts.user')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    {{-- <i class="fas fa-shipping-fast"></i> {{ env('APP_NAME') }} --}}
                                    <i class="fas fa-shipping-fast"></i> Peternakan Ibrahim Dadong Awok
                                    <small class="float-right">Tanggal: {{ $order->created_at->format('d-F-Y') }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Dari
                                <address>
                                    {{-- <strong>{{ env('APP_NAME') }}.</strong><br> --}}
                                    <strong>Peternakan Ibrahim Dadong Awok</strong><br>
                                    Dusun Ngadirejo, RT. 02 RW.04<br>
                                    Bangorejo, Banyuwangi, Jawa Timur<br>
                                    Telepon: (+62) 852 5722 9478<br>
                                    Email: ibrahimdadungawuk@gmail.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Tujuan
                                <address>
                                    <strong>{{ $order['user']['name'] }}</strong><br>
                                    {{ $order['shipping_address'] }}<br>
                                    Telepon: {{ $order['number'] }}<br>
                                    Email: {{ $order['user']['email'] }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #{{ $order->created_at->timestamp }}/{{ $order['id'] }}</b><br>
                                <b>Status Pembayaran : {{ $order['status'] }}</b><br>
                                @if($order['status'] === 'pending_payment')
                                <a href="{{ route('my.order.detail.upload',$order['id']) }}" class="btn btn-success">Unggah
                                    Bukti Transfer</a>
                                @endif
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Kuantitas</th>
                                        <th>Produk</th>
                                        <th>Harga /Kg</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Pembayaran</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order['orderDetails'] as $orderDetail)
                                        <tr>
                                            <td>{{ $orderDetail['amount'] }}</td>
                                            <td>{{ $orderDetail['productDetail']['product']['name'] }} {{ $orderDetail['productDetail']['name'] }}</td>
                                            <td>{{ $orderDetail['productDetail']['formatted_price'] }}</td>
                                            <td>{{ $orderDetail['productDetail']['product']['summary'] }}</td>
                                            <td>{{ formatPrice($orderDetail['amount'] * $orderDetail['productDetail']['price']) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                &nbsp;
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Metode Pengiriman</th>
                                            <td>{{$order['shipping']}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Jumlah Pembayaran:</th>
                                            <td>{{ $order['amount'] }}</td>
                                        </tr>
                                        @if($order['saldo'] !== 0)
                                            <tr>
                                                <th style="width:50%">Saldo:</th>
                                                <td>{{ $order['saldo'] }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ $order['total_payment'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        @if($order['payment_proof'] !== null)
                            <hr>
                            <h6>Bukti Pembayaran</h6>
                            <img src="{{ $order['payment_proof'] }}" style="height: 300px; width: auto">
                        @endif
                        <!-- /.row -->
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
