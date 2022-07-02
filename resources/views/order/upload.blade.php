@extends('layouts.user')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Konfirmasi Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="text-center">Total Pembayaran</h4>
                            <h2 class="text-center">{{ $order['total_payment'] }}</h2>
                            <p>No. Rekening Peternakan Ibrahim Dadong Awok</p>
                            <p>Nama Bank: BCA</p>
                            <p>Nama Akun Bank : PT.Blalblabla</p>
                            <p>No. Rekening : 123456789</p>
                            <hr>
                            <form action="{{ route('my.order.detail.upload.save', $order['id']) }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PATCH">
                                @csrf
                                <label>Upload Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-control" id="fileToUpload">
                                <br>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
    </section>
@endsection
