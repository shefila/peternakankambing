@extends('layouts.admin')

@section('title') Daftar Laporan Penjualan @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Laporan Penjualan</h3>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Transaksi Selesai</h4>
                                    <h2>{{ formatPrice($totalComplete) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Transaksi Tertunda</h4>
                                    <h2>{{ formatPrice($totalPending) }}</h2>
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
                                <th>Tagihan</th>
                                <th>Pengiriman</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td>{{ $order['user']['name'] }}</td>
                                    <td>{{ $order['shipping_address'] }}</td>
                                    <td>{{ $order['total_item'] }} ({{ $order['total_weight'] }} Kg)</td>
                                    <td>{{ $order['amount'] }}</td>
                                    <td>{{ $order['shipping']}}</td>
                                    <td>{{ $order['total_payment'] }}</td>
                                    <td>{{ $order['status'] }}</td>
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
