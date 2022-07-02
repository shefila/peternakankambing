@extends('layouts.user')

@section('title') Uang Tabunganku @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Uang Tabungan</h3>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h2>Saldo</h2>
                                <h1>{{ formatPrice($wallet['cash']) }}</h1>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center">
                                <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#addWithdrawal"><i
                                        class="fas fa-wallet"></i>
                                    Penarikan Tabungan
                                </button>
                            </div>
                            <div class="col-6 text-center">
                                <a href="/my/saving" class="btn btn-success btn-block"><i
                                        class="fas fa-plus"></i>
                                    Menabung
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Tanggal Penarikan Tabungan</th>
                            <th>Jumlah</th>
                            <th>Bukti Penarikan</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction['created_at']->format('Y-m-d H:i') }}</td>
                                <td>{{ formatPrice($transaction['amount']) }}</td>
                                <td>{!! $transaction['payment_proof_link'] !!}</td>
                                <td>{{ $transaction['status'] }}</td>
                                <td>
                                    @if($transaction['description'] !== null)
                                        @foreach(json_decode($transaction['description'], true) as $name => $value)
                                            {{ $name }} : {{ $value }}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($transaction['status'] === \App\Models\Transaction::STATUS_WAITING_APPROVAL)
                                        <a href="{{ route('my.withdrawal.cancel', $transaction['id']) }}"
                                           class="btn btn-danger">
                                            <i class="fas fa-trash"></i> cancel
                                        </a>
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

    <div id="addWithdrawal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Withdrawal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('my.withdrawal.submit') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Amount Withdrawal</label>
                            <input type="number" class="form-control" min="0" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label>Alasan penarikan</label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
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
