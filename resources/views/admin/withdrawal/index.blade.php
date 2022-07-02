@extends('layouts.admin')

@section('title') Persetujuan Daftar Penarikan Tabungan Pelanggan @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Penarikan Tabungan Pelanggan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Name</th>
                                <th>Jumlah Penarikan</th>
                                <th>Bukti Pembayaran</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['created_at']->format('Y-m-d H:i') }}</td>
                                    <td>{{ $transaction['wallet']['user']['name'] }}</td>
                                    <td>{{ formatPrice($transaction['amount']) }}</td>
                                    <td>{!! $transaction['payment_proof_link'] !!}</td>
                                    <td>
                                        @if($transaction['status'] === \App\Models\Transaction::STATUS_WAITING_APPROVAL)
                                            <button class="btn btn-success"
                                                    onclick="updatePayment('{{ $transaction['id'] }}','{{ $transaction['created_at']->format('Y-m-d H:i') }}','{{ $transaction['wallet']['user']['name'] }}','{{ formatPrice($transaction['amount']) }}','{{ $transaction['description'] }}')"
                                                    data-toggle="modal" data-target="#addWithdrawal"><i
                                                    class="fas fa-plus"></i> Kirim Bukti Transfer
                                            </button>
                                            <button class="btn btn-danger" data-toggle="modal"
                                                    onclick="rejectWithdraw('{{ $transaction['id'] }}')"
                                                    data-target="#cancelWithdrawal"><i
                                                    class="fas fa-trash"></i>
                                                cancel
                                            </button>
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
        function updatePayment(transaction_id, date, name, amount, description) {
            $('#date').text(date);
            $('#name').text(name);
            $('#amount').text(amount);
            $('#updatePayment').attr('action', '/withdrawal/update/' + transaction_id);
            var array_description =  JSON.parse(description);
            let detail = '';
            for (let key in array_description){
                detail += key+' : '+array_description[key]+'<br>'
            }
            $('#description').html(detail);
        }
        function rejectWithdraw(transaction_id) {
            $('#rejectPayment').attr('action', '/withdrawal/update/' + transaction_id+'/reject');
        }
    </script>

    <div id="addWithdrawal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kirim Bukti Transfer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="updatePayment" action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="modal-body">
                        @csrf
                        <p>Update payment untuk transaksi</p>
                        <p>Tanggal : <b id="date"></b></p>
                        <p>Nama : <b id="name"></b></p>
                        <p>Jumlah : <b id="amount"></b></p>
                        <p id="description"></p>
                        <div class="form-group">
                            <label>Image</label>
                            <input name="payment_proof" type="file" class="form-control"
                                   accept="image/*" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="cancelWithdrawal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alasan Cancel</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="rejectPayment" action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Alasan penarikan tidak diterima</label>
                            <textarea class="form-control" rows="6" name="description" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop
