@extends('layouts.admin')

@section('title') Daftar Pesanan @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pesanan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pengiriman</th>
                                <th>Pengiriman</th>
                                <th>Total Item</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Status</th>
                                <th>Lihat Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order['user']['name'] }}</td>
                                    <td>{{ $order['shipping_address'] }}</td>
                                    <td>{{ $order ['shipping']}}</td>
                                    <td>{{ $order['total_item'] }} ({{ $order['total_weight'] }})</td>
                                    <td>{{ $order['total_payment'] }}</td>
                                    @if($order['status'] === 'done')
                                    <td>Selesai</td>
                                    @elseif ($order['status'] === 'pending_payment')
                                    <td>Pembayaran Tertunda</td>
                                    @elseif($order['status'] === 'success_payment')
                                    <td>Pembayaran Sukses</td>
                                    @endif
                                    <td>
                                        <a href="/order/{{ $order['id'] }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    </td>
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
