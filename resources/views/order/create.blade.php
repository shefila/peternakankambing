@extends('layouts.user')

@section('title') Buat Pesanan Baru  @stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="/add-to-cart" method="POST" id="form-add-to-cart">
                @csrf
                <input type="hidden" name="product_id" id="product_id">
            </form>
            <form action="/remove-from-cart" id="form-remove-from-cart" method="POST">
                @csrf
            </form>
            <form action="/create-order" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Jenis Produk</h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <select class="form-control" required id="variant_id"
                                                    onchange="$('#product_id').val($('#variant_id').val())">
                                                <option>-- Pilih Produk --</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button"
                                                onclick="document.getElementById('form-add-to-cart').submit()"
                                                class="btn btn-primary">Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Pemesanan</h3>
                            </div>
                            <div class="card-body" id="productVariant">
                                <div class="row">
                                    <div class="col-8">
                                        <label>Jenis Produk/Berat - Stok</label>
                                    </div>
                                    <div class="col-3">
                                        <label>Jumlah</label>
                                    </div>
                                    <div class="col-1">
                                        &nbsp;
                                    </div>
                                </div>
                                @foreach($cart as $item)
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <select class="form-control" name="product_detail_id[]" required>
                                                @foreach($item['productDetails'] as $variant)
                                                    <option value="{{ $variant['id'] }}">{{ $item['product']['name'] }}
                                                        - {{ $variant['name'] }} {{ $variant['detail'] }} ({{ formatPrice($variant['price']) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" min="1" class="form-control" name="amount[]" value="{{ $item['amount'] }}" required>
                                        </div>

                                        <div class="col-1">
                                            <button type="button"
                                                    onclick="$('#form-remove-from-cart').attr('action','/remove-from-cart/{{ $item['id'] }}'); $('#form-remove-from-cart').submit()"
                                                    class="btn btn-danger btn-sm"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Uang Tabungan</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h4>Saldo saya sekarang</h4>
                                        <h3>{{ formatPrice($wallet['cash']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Pengiriman</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                           value="{{ auth()->user()['name'] }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No. Telepon</label>
                                    <input type="text" placeholder="08XX-XXXX-XXXX" class="form-control" name="number" rows="4">                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Pengiriman</label>
                                    <textarea class="form-control" name="shipping_address" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pilihan</label>
                                    <select class="form-control" name="shipping" required>
                                        <option>-- Metode Pengiriman --</option>
                                        <option value="DI AMBIL">DI AMBIL</option>
                                        <option value="DI ANTAR">DI ANTAR</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="use_wallet"> Gunakan saldo saya untuk membayar pesanan
                                </div>
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop
