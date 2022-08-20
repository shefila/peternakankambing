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
                            <h2 class="text-center">{{ formatPrice($transaction['amount']) }}</h2>
                            <p>No. Rekening Peternakan Ibrahim Dadong Awok</p>
                            <p>Nama Bank: BCA</p>
                            <p>Nama Akun Bank : Sugiartha Mubarok</p>
                            <p>No. Rekening : 8980570623</p>
                            <hr>
                            <form action="{{ route('my.saving.upload.payment', $transaction['id']) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label>Unggah Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-control" required>
                                <br>
                                <button type="submit" class="btn btn-primary">Unggah</button>
                            </form>
                        </div>

                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
    </section>
@endsection
