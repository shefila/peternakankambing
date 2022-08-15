@extends('layouts.admin')

@section('title') History Stok @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">History Stok</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Stok</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyStocks as $data )
                                <tr>
                                    <td>{{$data['created_at']}}</td>
                                    <td>{{$data['productDetail']['product']['name']}} {{$data['productDetail']['name']}}</td>
                                    <td>{{$data['stock']}}</td>
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
