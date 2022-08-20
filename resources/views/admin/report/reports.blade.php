@extends('layouts.admin')

@section('title') Daftar Laporan Laba Rugi @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Laporan Laba Rugi</h3>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Modal</h4>
                                    <h2>{{formatPrice($modal)}}</h2>
                                    <label>Harga beli kambing</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Omset</h4>
                                    <h2>{{formatPrice($omset)}}</h2>
                                    <label>Keseluruhan harga jual</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>{{ $untungRugi >= 0 ? 'Untung':'Rugi'}}</h4>
                                    <h2>{{formatPrice($untungRugi)}}</h2>
                                    <label>Omset - harga beli</label>

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
                                <th>Omset</th>
                                <th>Modal</th>
                                <th>Untung</th>

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
