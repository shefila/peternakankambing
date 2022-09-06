@extends('layouts.admin')

@section('title') Laporan Penjualan @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Laporan Penjualan</h3>
                        <br>
                        @if(isset($_GET['start_date']) && isset($_GET['end_date']))
                            @if($_GET['start_date'] === $_GET['end_date'] && $_GET['start_date'] === now()->format('Y-m-d'))
                                <p>Filter Date : Today</p>
                            @elseif($_GET['start_date'] === $_GET['end_date'] && $_GET['start_date'] !== now()->format('Y-m-d'))
                                <p>Filter Date : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $_GET['start_date'])->format('j F Y') }}</p>
                            @else
                                <p>Filter Date
                                    : {{ \Carbon\Carbon::createFromFormat('Y-m-d', $_GET['start_date'])->format('j F Y') }}
                                    - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $_GET['end_date'])->format('j F Y') }}</p>
                            @endif
                        @else
                            <p>Filter Date : All time</p>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Modal</h4>
                                    <h2>{{formatPrice($modal)}}</h2>
                                    <label>Harga beli produk yang terjual</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Omset</h4>
                                    <h2>{{formatPrice($omset)}}</h2>
                                    <label>Keseluruhan pendapatan penjualan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>{{ $untungRugi >= 0 ? 'Laba':'Rugi'}}</h4>
                                    <h2>{{formatPrice($untungRugi)}}</h2>
                                    <label>Omset - modal</label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" method="GET">
                            <label>Mulai : </label>
                            <input type="date" class="form-control col-md-4" name="start_date" value="{{ isset($_GET['start_date'])?$_GET['start_date']:now()->format('Y-m-d') }}">
                            <label>Akhir : </label>
                            <input type="date" class="form-control col-md-4" name="end_date" value="{{ isset($_GET['end_date'])?$_GET['end_date']:now()->format('Y-m-d') }}">
                            <p></p>
                            <button type="submit" class="form-control btn btn-pro btn-info btn-s col-md-2">Filter</button>
                        </form>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pengiriman</th>
                                <th>Total Item</th>
                                <th>Jenis Produk</th>
                                <th>Omset (Keseluruhan pendapatan penjualan)</th>
                                <th>Modal (Harga beli produk yang terjual)</th>
                                <th>Laba (Omset-modal)</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td>{{ $order['user']['name'] }}</td>
                                    <td>{{ $order['shipping_address'] }}</td>
                                    <td>{{ $order['total_item'] }} item ({{ $order['total_weight'] }} )</td>
                                    <td>{{ $order->orderDetails()->first()->productDetail->product['name'] }}</td>
                                    <td>{{ $order['amount'] }}</td>
                                    <td>{{ $order['modal'] }}</td>
                                    <td>{{ $order['untung'] }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@stop
