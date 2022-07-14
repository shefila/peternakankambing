@extends('layouts.admin')

@section('title') Produk Detail @stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produk Detail</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 text-right">
                                    <img src="{{ $product['image'] }}" style="height: 200px; width: auto">
                                </div>
                                <div class="col-8">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Nama</td>
                                            <td colspan="2">{{ $product['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis</td>
                                            <td colspan="2">{{ $product['summary'] }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Deskripsi : <br>
                                                {{ $product['description'] }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addData"><i
                                class="fas fa-plus"></i> Tambahkan Jenis Produk
                        </button>
                        <hr>
                        <div class="row">
                            @foreach($product->productDetails()->get() as $productDetail)
                                <div class="col-md-4">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ $productDetail['name'] }}</h4>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ $productDetail['image'] }}" style="height: 100px; width: auto;">
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <p><i class="fas fa-info-circle"></i> Detail : {{ $productDetail['detail'] }}</p>
                                                    <p><i class="fas fa-coins"></i> Harga : {{ formatPrice($productDetail['price']) }}</p>
                                                    <form class="form-group row" action="{{ route('productVariant.update', $productDetail['id']) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PATCH">
                                                        <label class="col-4 mt-2"><i class="fas fa-box"></i> Stock :</label>
                                                        <input type="number" class="form-control col-4" name="stock" value="{{ $productDetail['stock'] }}" required onkeyup="$('#btn-update-productVariant-{{ $productDetail['id'] }}').show()">
                                                        <button type="submit" class="btn btn-sm btn-primary col-4" style="display: none" id="btn-update-productVariant-{{ $productDetail['id'] }}">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <form
                                                        action="{{ route('productVariant.remove', $productDetail['id']) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="button" onclick="$('#updateImg').attr('action','/product/updateVariant/{{ $productDetail['id'] }}'); $('#stockVariant').val('{{ $productDetail['stock'] }}')" class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateImage"><i
                                                            class="fas fa-pen"></i> Update Gambar</button>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="fas fa-trash"></i> Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <div id="addData" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambahkan Jenis Produk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('productVariant.add', $product['id']) }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Gambar</label>
                            <input name="image" type="file" class="form-control"
                                   accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" min="0" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Detail</label>
                            <input type="text" min="0" class="form-control" name="detail" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" min="0" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" min="0" class="form-control" name="stock" required>
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


    <div id="updateImage" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Gambar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="updateImg" action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="stock" id="stockVariant" value="0">
                        <div class="form-group">
                            <label>Gambar</label>
                            <input name="image" type="file" class="form-control"
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

@stop
