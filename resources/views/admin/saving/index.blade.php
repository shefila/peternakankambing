@extends('layouts.admin')

@section('title')
    Persetujuan Daftar Penyetoran Tabungan Pelanggan
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Penyetoran Tabungan Pelanggan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Nama Penabung</th>
                                <th>Menyetorkan</th>
                                <th>Bukti Pembayaran</th>
                                <th>Lihat Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['created_at']->format('Y-m-d H:i') }}</td>
                                    <td>{{ $transaction['wallet']['user']['name'] }}<br>Saldo
                                        : {{ formatPrice($transaction['wallet']['cash']) }}</td>
                                    <td>{{ $transaction['savingRelation']['name'] }}</td>
                                    <td>{{ formatPrice($transaction['amount']) }}</td>
                                    <td>{!! $transaction['payment_proof_link'] !!}</td>
                                    <td>
                                        @if($transaction['status'] === \App\Models\Transaction::STATUS_WAITING_APPROVAL)
                                            <button type="button" onclick="accept('{{ $transaction['id'] }}')"
                                                    class="btn btn-success btn-sm"><i
                                                    class="fas fa-check"></i></button>

                                            <button type="button" onclick="reject('{{ $transaction['id'] }}')"
                                                    class="btn btn-danger btn-sm"><i
                                                    class="fas fa-times"></i></button>
                                        @endif
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
    <script>
        function accept(transaction_id) {
            Swal.fire({
                title: 'Apakah anda yakin akan menerima setoran ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/saving/update/'+transaction_id,
                        type: 'POST',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'status': '{{ \App\Models\Transaction::STATUS_SUCCESS }}',
                            '_method': 'PATCH',
                        },
                        dataType: 'json',
                        status: status,
                    }).done(function (result, textStatus, jqXHR) {
                        if (result.success) {
                            Swal.fire(
                                'Success!',
                                result.message,
                                'success'
                            ).then((result) => {
                                window.location.href = '/saving';
                            });
                        }
                    }).fail(function (jqXHR, textStatus, err) {
                        console.log(err);
                    }).always(function () {
                        console.log('finished');
                    });
                }
            })
        }
    </script>

    <script>
        function reject(transaction_id) {
            Swal.fire({
                title: 'Apakah anda yakin akan menolak setoran ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/saving/update/'+transaction_id,
                        type: 'POST',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'status': '{{ \App\Models\Transaction::STATUS_FAILED }}',
                            '_method': 'PATCH',
                        },
                        dataType: 'json',
                        status: status,
                    }).done(function (result, textStatus, jqXHR) {
                        if (result.success) {
                            Swal.fire(
                                'Success!',
                                result.message,
                                'success'
                            ).then((result) => {
                                window.location.href = '/saving';
                            });
                        }
                    }).fail(function (jqXHR, textStatus, err) {
                        console.log(err);
                    }).always(function () {
                        console.log('finished');
                    });
                }
            })
        }
    </script>

@stop
