@extends('layouts.user')

@section('title') Tabungan @stop

@section('content')
    <section>
        <div class="card">
            <div class="card-body">
                <button class="btn btn-success" data-toggle="modal" data-target="#addSaldo"><i class="fas fa-plus"></i>
                    Buat Rencana Tabungan Baru
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- /.col -->
                    @foreach($savings as $saving)
                        <div class="col-md-4">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $saving['name'] }}</h3>

                                    <div class="card-tools">
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body text-center">
                                    <h3>{{ $saving['progress_percent'] }} %</h3>
                                    <h4>{{ formatPrice($saving['total']) }}/{{ formatPrice($saving['target']) }}</h4>
                                    <a href="{{ route('my.saving.detail', $saving['id']) }}" class="btn btn-info">Lihat Detail Tabungan</a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div id="addSaldo" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tabungan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('my.saving.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Rencana menabung untuk</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Nominal yang ingin dicapai</label>
                            <input type="number" min="0" class="form-control" name="target" required>
                        </div>
                        <div class="form-group">
                            <label>Waktu yang ingin dicapai</label>
                            <input type="date" class="form-control" name="due_date" required>
                        </div>
                        <div class="form-group">
                            <label>Rencana periode menabung rutin</label>
                            <select class="form-control" name="period" required>
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Models\Saving::PERIODS as $name => $period)
                                    <option value="{{ $period }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop
