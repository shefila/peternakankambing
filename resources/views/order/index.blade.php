@extends('layouts.user')

@section('title') Pesan @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h1>Stok Kambing lagi banyak, Beli sekarang</h1>
                        <a href="{{ route('my.order.new') }}" class="btn btn-success">Beli sekarang</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pesananku</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Alamat Pengiriman</th>
                                <th>Total item</th>
                                <th>Pengiriman</th>
                                <th>Tagihan</th>
                                <th>Uang Tabungan</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th>Lihat Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order['shipping_address'] }}</td>
                                    <td>{{ $order['total_item'] }} ({{ $order['total_weight'] }})</td>
                                    <td>{{ $order['shipping']}}</td>
                                    <td>{{ $order['amount'] }}</td>
                                    <td>{{ $order['saldo'] }}</td>
                                    <td>{{ $order['total_payment'] }}</td>
                                    @if($order['status'] === 'done')
                                    <td>Selesai</td>
                                    @elseif ($order['status'] === 'pending_payment')
                                    <td>Menunggu Verifikasi</td>
                                    @elseif($order['status'] === 'success_payment')
                                    <td>Pembayaran Sukses</td>
                                    @endif
                                    <td>
                                        <a href="/my/order/invoice/{{ $order['id'] }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
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
