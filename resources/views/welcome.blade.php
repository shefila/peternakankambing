<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="html 5 template">
    <meta name="author" content="">
    <title>Proyek Akhir - Aplikasi Tabungan</title>
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="/landing/favicon.ico">
    <link rel="stylesheet" href="/landing/css/jquery-ui.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="/landing/font/flaticon.css">
    <link rel="stylesheet" href="/landing/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/landing/css/fontawesome-5-all.min.css">
    <link rel="stylesheet" href="/landing/css/font-awesome.min.css">
    <!-- ARCHIVES CSS -->
    <link rel="stylesheet" href="/landing/css/search-form.css">
    <link rel="stylesheet" href="/landing/css/search.css">
    <link rel="stylesheet" href="/landing/css/animate.css">
    <link rel="stylesheet" href="/landing/css/aos.css">
    <link rel="stylesheet" href="/landing/css/aos2.css">
    <link rel="stylesheet" href="/landing/css/magnific-popup.css">
    <link rel="stylesheet" href="/landing/css/lightcase.css">
    <link rel="stylesheet" href="/landing/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/landing/css/bootstrap.min.css">
    <link rel="stylesheet" href="/landing/css/menu.css">
    <link rel="stylesheet" href="/landing/css/slick.css">
    <link rel="stylesheet" href="/landing/css/styles.css">
    <link rel="stylesheet" id="color" href="/landing/css/default.css">
</head>

<body class="homepage-3 the-search">
<!-- Wrapper -->
<div id="wrapper">
    <!-- START SECTION HEADINGS -->
    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="header head-tr">
        <!-- Header -->
        <div id="header" class="head-tr bottom">
            <div class="container container-header">
                <!-- Left Side Content -->
                <div class="left-side">
                    <!-- Logo -->
                    <div id="logo">
                        <a href="index.html"><img src="/landing/images/logo-peternakan.jpeg"
                                                  style="margin-left: auto; margin-right: auto"
                                                  data-sticky-logo="images/logo-purple.svg" alt=""></a>
                    </div>
                    <!-- Main Navigation -->
                    <nav id="navigation" class="style-1 head-tr">
                        <ul id="responsive">
                            <li><a href="#">Beranda</a></li>
                            <li><a href="#produk">Produk</a></li>
                            <li><a href="#tentang">Tentang</a></li>
                            <li><a href="#kontak">Kontak</a></li>
                        </ul>
                    </nav>
                    <!-- Main Navigation / End -->
                </div>
                <!-- Left Side Content / End -->
                <div class="right-side d-none d-none d-lg-none d-xl-flex" style="margin-right: 10px">
                    <!-- Header Widget -->
                    <div class="header-widget">
                        @if(auth()->user())
                        <a href="{{ auth()->user()['is_admin']?'/order':'/my/order/new' }}" class="button border text-center" style="color: #3446eb"><i class="fas fa-lock ml-2"></i> Dashboard</a>
                        @else
                        <a href="/login" class="button border text-center" style="color: #3446eb"><i class="fas fa-lock ml-2"></i> Login</a>
                        @endif
                    </div>
                    <!-- Header Widget / End -->
                </div>
            </div>
        </div>
        <!-- Header / End -->

    </header>
    <div class="clearfix"></div>
    <!-- Header Container / End -->

    <!-- START SECTION Info -->
    <section class="info-help h17">
        <div class="container">
            <div class="row info-head">
                <div class="col-lg-6 col-md-8 col-xs-8" data-aos="fade-right">
                    <div class="info-text">
                        <h3>Memudahkan anda mencari Kambing dan paket Aqiqah</h3>
                        <h5 class="mt-3">harga mulai {{ formatPrice($min_price_product) }}</h5>
                        <p class="pt-2">
                            Rekomendasi membeli Kambing Untuk Qurban Dan Aqiqah</p>
                        <div class="inf-btn pro">
                            @if (auth()->user())
                            <a href="{{ auth()->user()['is_admin']?'/order':'/my/order/new' }}" class="btn btn-pro btn-secondary btn-lg">Dashboard</a>
                            @else
                            <a href="/login" class="btn btn-pro btn-secondary btn-lg">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-3"></div>
            </div>
        </div>
    </section>
    <!-- END SECTION Info -->

    <!-- START SECTION Promosi -->
    @foreach($products as $product)
    <section class="featured portfolio bg-white-2 rec-pro" id="produk">
        <div class="container-fluid">
            <div class="sec-title">
                <h2><span>{{ $product['name'] }}</span></h2>
                <h5>{{ $product['description']}}</h5>
            </div>
            <div class="portfolio col-xl-12">
                <div class="slick-lancers2">
                    @foreach($product->productDetails as $productDetail)
                        <div class="agents-grid">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <!-- homes img -->
                                            <a href="#" class="homes-img">
                                                 <img src="{{ $productDetail['image'] }}" alt="home-1" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- homes content -->
                                    <div class="homes-content">
                                        <!-- homes address -->
                                        <h3><a href="#">{{ $productDetail['name'] }}</a></h3>
                                        <!-- homes List -->
                                        <span>{{ $productDetail['detail'] }}</span>
                                               <p> <i class="fas fa-pen"></i>
                                                 <span>{{ $productDetail['description'] }}</span>
                                               </p>
                                        <ul class="homes-list clearfix">
                                            <li class="the-icons">
                                                <i class="fas fa-box mr-2"></i>
                                                 <span>{{ $productDetail['stock'] }}</span>
                                            </li>
                                        </ul>
                                        <div class="price-properties footer pt-3 pb-0">
                                            <h3 class="title mt-3" style="text-transform: none">
                                                <a href="#">{{ formatPrice($productDetail['price']) }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="inf-btn pro" style="text-align: center">
                                        <a href="/my/buy/{{$productDetail['id']}}" class="col-12 btn btn-pro btn-secondary btn-lg">Beli</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- END SECTION Promosi -->
    @endforeach

    {{-- <center><h2>KAMBING GIBAS</p></center> --}}

    <!-- START SECTION Mengapa memilih kami -->
    <section class="how-it-works bg-white" id="tentang">
        <div class="container">
            <div class="sec-title">
                <h2><span>MENGAPA </span>MEMILIH KAMI</h2>
                <h5>Kami menyediakan layanan penuh di setiap langkah</h5>
            </div>
            <div class="row service-1">
                <article class="col-lg-4 col-md-6 col-xs-12 serv" data-aos="zoom-in" data-aos-delay="150">
                    <div class="serv-flex">
                        <div class="art-1 img-13">
                            <img src="/landing/images/icons/icon-12.jpeg" alt="">
                            <h3>Pembelian kambing dan paket aqiqah lebih mudah</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">Pembelian kambing dan paket aqiqah di Peternakan Ibrahim Dadong Awok melalui website sangat memudahkan pelanggan
                                untuk proses pembelian produk, sehingga pelanggan tidak harus mendatangi peternakan. juga terdapat fitur menabung yang memudahkan pelanggan dalam pembelian kambing </p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-4 col-md-6 col-xs-12 serv" data-aos="zoom-in" data-aos-delay="250">
                    <div class="serv-flex">
                        <div class="art-1 img-14">
                            <img src="/landing/images/icons/icon-35.jpeg" alt="">
                            <h3>Dipercaya banyak orang</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center"> Peternakan Ibrahim Dadong Awok merupakan peternakan modern yang terpercaya,
                                melayani pembelian kambing dan paket aqiqah siap saji. Pelanggan bisa sharing atau bertukar pengalaman mengenai perjalanan/proses beternak kambing</p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-4 col-md-6 col-xs-12 serv mb-0 pt" data-aos="zoom-in" data-aos-delay="350">
                    <div class="serv-flex arrow">
                        <div class="art-1 img-15">
                            <img src="/landing/images/icons/icon-34.jpeg" alt="">
                            <h3>Bekerja sesuai Syariat Islam</h3>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">Peternakan Ibrahim Dadong Awok mulai merintis usaha hingga saat ini dan juga kedapannya selalu bekerja sesuai syariat islam.
                                Kambing qurban dan kambing aqiaah harus berumur 1 tahun atau memasuki tahun kedua.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <!-- END SECTION Mengapa Memilih Kami -->

    <section class="bg-white-2 col-md-12" id="kontak">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <h2 style="text-align: center"><span></span>Syarat & Ketentuan</h2>
                    <p style="text-align: center">Syarat dan ketentuan pembelian kambing dan aqiqah</p>
                    <p>1. Pelanggan wajib mengisi data tabungan qurban dengan lengkap dan benar</p>
                    <p>2. Jika pelanggan sudah menabung akan tetapi tidak dapat membeli hewan qurban tahun ini, maka mengikuti tabungan tahun berikutnya</p>
                    <p>3. Pelunasan pembelian hewan qurban paling lambat 1 (satu) bulan sebelum Idul Adha</p>
                    <p>4. Free ongkos kirim pengiriman produk area Bangorejo, Purwoharjo, Cluring, dan Gambiran</p>
                    <p></p>
                </div>
                <div class="col-md-6">
                    <br>
                    <h2 style="text-align: center"><span></span>Map</h2>
                    <p style="text-align: center">Lokasi Peternakan Ibrahim Dadong Awok</p>
                    <p style="text-align: center">
                    <iframe style="border: 0; height: 300px; width: 500px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.2916739136012!2d114.18899041433419!3d-8.470992388006305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd3ff29ff467837%3A0x10f5137e72c768b6!2sjual%20beli%20kambing%20IBRAHIM!5e0!3m2!1sen!2sid!4v1649763237184!5m2!1sen!2sid"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- START FOOTER -->
    <footer class="first-footer">
        <div class="top-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-6">
                        <div class="netabout" style="color: white;">
                                    <img src="/landing/images/logo-peternakan.jpeg" style="width: 50px;height: 50px;">
                                     &nbsp; PETERNAKAN IBRAHIM DADONG AWOK
                                        <p class="in-p">Peternakan Ibrahim Dadong Awok merupakan peternakan modern yang berada di Bangorejo, Banyuwangi.
                                            Peternakan ini melayani pembelian kambing dan paket aqiqah, juga melayani tabungan qurban setiap tahun.
                                        </p>
                        </div>
                        <div class="contactus">
                            <ul>
                                <li>
                                    <div class="info">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <p class="in-p">Dusun Ngadirejo, RT. 02 RW. 04, Bangorejo, Banyuwangi, Jawa Timur, 68471</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="info">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <p class="in-p">+62 852 5722 9478</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="info">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <p class="in-p ti">ibrahimdadungawuk@gmail.com</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="newsletters">
                            <h3>INFORMASI</h3>
                            <p>Kunjungi youtube kami dan subscribe agar bisa melihat lebih banyak konten dari channel kami.
                                </p>
                        </div>
                        <a href="https://www.youtube.com/c/IbrahimDADONGAWOKfarm" class="btn btn-success">Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-footer">
            <div class="container">
                <p>2022 © Copyright Peternakan Ibrahim Dadong Awok with {{ env('APP_NAME') }} - All Rights Reserved.</p>
                <ul class="netsocials">
                    <li><a href="https://www.facebook.com/peternakkambingaslibanyuwangi/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    {{-- <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> --}}
                    <li><a href="https://www.instagram.com/ibrahim_dadong_awok/"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://www.youtube.com/c/IbrahimDADONGAWOKfarm"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
    <!-- END FOOTER -->

    <!-- START PRELOADER -->
    <div id="preloader">
        <div id="status">
            <div class="status-mes"></div>
        </div>
    </div>
    <!-- END PRELOADER -->

    <!-- ARCHIVES JS -->
    <script src="/landing/js/jquery-3.5.1.min.js"></script>
    <script src="/landing/js/rangeSlider.js"></script>
    <script src="/landing/js/tether.min.js"></script>
    <script src="/landing/js/moment.js"></script>
    <script src="/landing/js/bootstrap.min.js"></script>
    <script src="/landing/js/mmenu.min.js"></script>
    <script src="/landing/js/mmenu.js"></script>
    <script src="/landing/js/aos.js"></script>
    <script src="/landing/js/aos2.js"></script>
    <script src="/landing/js/slick.min.js"></script>
    <script src="/landing/js/fitvids.js"></script>
    <script src="/landing/js/fitvids.js"></script>
    <script src="/landing/js/jquery.waypoints.min.js"></script>
    <script src="/landing/js/jquery.counterup.min.js"></script>
    <script src="/landing/js/imagesloaded.pkgd.min.js"></script>
    <script src="/landing/js/isotope.pkgd.min.js"></script>
    <script src="/landing/js/smooth-scroll.min.js"></script>
    <script src="/landing/js/lightcase.js"></script>
    <script src="/landing/js/search.js"></script>
    <script src="/landing/js/owl.carousel.js"></script>
    <script src="/landing/js/jquery.magnific-popup.min.js"></script>
    <script src="/landing/js/ajaxchimp.min.js"></script>
    <script src="/landing/js/newsletter.js"></script>
    <script src="/landing/js/jquery.form.js"></script>
    <script src="/landing/js/jquery.validate.min.js"></script>
    <script src="/landing/js/searched.js"></script>
    <script src="/landing/js/forms-2.js"></script>
    <script src="/landing/js/range.js"></script>
    <script src="/landing/js/color-switcher.js"></script>
    <script>
        $(window).on('scroll load', function () {
            $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
        });

    </script>

    <!-- Slider Revolution scripts -->
    <script src="/landing/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="/landing/revolution/js/jquery.themepunch.revolution.min.js"></script>

    <script>
        $('.slick-lancers').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: true,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 1292,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
            }, {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                }
            },]
        });

    </script>
    <script>
        $('.slick-lancers2').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: true,
            arrows: false,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 1292,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
            }, {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: true,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                }
            },]
        });

    </script>
    <script>
        $('.job_clientSlide').owlCarousel({
            items: 2,
            loop: true,
            margin: 30,
            autoplay: false,
            nav: true,
            smartSpeed: 1000,
            slideSpeed: 1000,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                991: {
                    items: 2
                }
            }
        });

    </script>

    <script>
        $(".dropdown-filter").on('click', function () {

            $(".explore__form-checkbox-list").toggleClass("filter-block");

        });

    </script>

    <!-- MAIN JS -->
    <script src="/landing/js/script.js"></script>

</div>
<!-- Wrapper / End -->
</body>

</html>
