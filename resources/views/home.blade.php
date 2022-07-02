@extends('layouts.user')

@section('title') Product @stop

@section('content')
    <section>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- /.col -->
                    @foreach($products as $product)
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ $product['name'] }}</h3>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6 text-left">
                                        {{-- <p>Stock : <i class="fas fa-box"></i> {{ $product->productDetails()->sum('stock') }}</p> --}}
                                    </div>
                                </div>
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
                                                            <p><i class="fas fa-box"></i> Stock : {{ $productDetail['stock'] }}</p>
                                                            <p><i class="fas fa-coins"></i> Price : {{ formatPrice($productDetail['price']) }}</p>
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
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@stop
