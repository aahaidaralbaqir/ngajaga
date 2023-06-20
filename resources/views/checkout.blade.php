<!DOCTYPE html>
<html>
    <head>

        <!-- /.website title -->
        <title>Bayar Zakat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSS Files -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" rel="stylesheet">
        <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet" media="screen">
        <link href="{{ URL::asset('css/owl.theme.css') }} " rel="stylesheet">
        <link href="{{ URL::asset('css/owl.carousel.css') }}" rel="stylesheet">

        <!-- Colors -->
        <link href="{{ URL::asset('css/css-index.css') }}" rel="stylesheet" media="screen">
        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">
        <!-- <link href="css/css-index-#1f96e0.css" rel="stylesheet" media="screen"> -->
        <!-- <link href="css/css-index-purple.css" rel="stylesheet" media="screen"> -->
        <!-- <link href="css/css-index-red.css" rel="stylesheet" media="screen"> -->
        <!-- <link href="css/css-index-orange.css" rel="stylesheet" media="screen"> -->
        <!-- <link href="css/css-index-yellow.css" rel="stylesheet" media="screen"> -->

        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" />

    </head>

    <body data-spy="scroll" data-target="#navbar-scroll">

        <!-- /.preloader -->
        <div id="preloader"></div>
        <div id="top"></div>

        <!-- NAVIGATION -->
        <div id="menu">
            <nav class="navbar-wrapper navbar-default" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-backyard">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand site-name" href="#top" style="display: flex; align-items: center; gap: 10px;">
                            <img src="https://blogger.googleusercontent.com/img/a/AVvXsEj0AfwOMTisZZKXm0z1loDJ0Y6kwK-uh259QVZWY4_iK2I19-0Kmr9K3NPaAnEJAX9ftIgV_PMyWYyN_DHqIFWTQT2VqsMc2DO-8VnrBjzWxGoPrJggO3hrBZ26VHB6EVN1rEk43wb6MTPSWzl_QL9mp3GLLFQ6s-zJaboWmZT-fhP5GFXjjN4IlsI34w=s16000" alt="logo">
                            Masjid Darul Ulum
                        </a>
                    </div>

                    <div id="navbar-scroll" class="collapse navbar-collapse navbar-backyard navbar-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#intro">Profile</a></li>
                            <li><a href="#feature">Kegiatan</a></li>
                            <li><a href="#download">Jadwal</a></li>
                            <li><a href="#package">Struktur Organisasi</a></li>
                            <li><a href="#testi">Buletin</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div id="main">
            <div class="container">
                <div class="s-container form-header">
                    <img src="https://baznas.go.id/application/views/assets/images/banner_zakat.jpg" alt="">
                    <h2>TUNAIKAN ZAKAT, INFAK, DAN SEDEKAH ANDA DENGAN <span style="color: #1f96e0">AMAN DAN MUDAH</span></h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <h3>Pilih Jenis Dana</h3>
                                <select name="id_transaction_type" class="form-control">
                                    @foreach ($transaction_type as $item)
                                        @php
                                            $checked = FALSE;
                                            if ($item->id == $transaction_record->id_transaction_type)
                                                $checked = TRUE;
                                        @endphp
                                        <option value="{{ $item->id }}" {{ $checked ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">Rp</span>
                                    <input type="text" class="form-control" name="paid_amount" placeholder="Masukan Nominal" aria-describedby="basic-addon1">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Silahkan lengkapi data diri anda:</h3>
                       
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name', $transaction_record->customer->name) }}" />
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="phone_number" value="{{ old('name', $transaction_record->customer->phone_number) }}" placeholder="Nomer gawai">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $transaction_record->customer->email) }}">
                        </div>
                    </div>
                    <span>
                        Dengan mengisi formulir ini, donatur akan menerima Bukti Setor Zakat (BSZ), laporan penyaluran, info layanan BAZNAS melalui email & whatsapp.
                    </span>
                    <button class="btn btn-primary btn-block">Pilih Metode Pembayaran</button>
                </div>
            </div>
        </div>
    
        <!-- /.contact section -->
        <div id="contact">
            <div class="contact fullscreen parallax" style="background-image:url('https://c4.wallpaperflare.com/wallpaper/640/409/86/religion-city-aerial-photography-metropolis-wallpaper-preview.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
                <div class="overlay">
                    <div class="container">
                        <div class="row contact-row">

                            <!-- /.address and contact -->
                            <div class="col-sm-5 contact-left wow fadeInUp">
                                <h2><span class="highlight">Get</span> in touch</h2>
                                <ul class="ul-address">
                                    <li><i class="pe-7s-map-marker"></i>1600 Amphitheatre Parkway, Mountain View</br>
                                        California 55000
                                    </li>
                                    <li><i class="pe-7s-phone"></i>+1 (123) 456-7890</br>
                                        +2 (123) 456-7890
                                    </li>
                                    <li><i class="pe-7s-mail"></i><a href="/cdn-cgi/l/email-protection#deb7b0b8b19ea7b1abacadb7aabbf0bdb1b3"><span class="__cf_email__" data-cfemail="dbb2b5bdb49ba2b4aea9a8b2afbef5b8b4b6">[email&#160;protected]</span></a></li>
                                    <li><i class="pe-7s-look"></i><a href="#">www.yoursite.com</a></li>
                                </ul>	

                            </div>

                            <!-- /.contact form -->
                            <div class="col-sm-7 contact-right">
                                <form method="POST" id="contact-form" class="form-horizontal" action="contactengine.php" onSubmit="alert( 'Thank you for your feedback!' );">
                                    <div class="form-group">
                                        <input type="text" name="Name" id="Name" class="form-control wow fadeInUp" placeholder="Name" required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="Email" id="Email" class="form-control wow fadeInUp" placeholder="Email" required/>
                                    </div>					
                                    <div class="form-group">
                                        <textarea name="Message" rows="20" cols="20" id="Message" class="form-control input-message wow fadeInUp"  placeholder="Message" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Submit" class="btn btn-success wow fadeInUp" />
                                    </div>
                                </form>		
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.footer -->
        <footer id="footer">
            <div class="container">
                <div class="col-sm-4 col-sm-offset-4">
                    <!-- /.social links -->
                    <div class="social text-center">
                        <ul>
                            <li><a class="wow fadeInUp" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="wow fadeInUp" href="https://www.facebook.com/" data-wow-delay="0.2s"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="wow fadeInUp" href="https://plus.google.com/" data-wow-delay="0.4s"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="wow fadeInUp" href="https://instagram.com/" data-wow-delay="0.6s"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>	
                    <div class="text-center wow fadeInUp" style="font-size: 14px;">Copyright Backyard 2015 - Template by  <a href="https://bootstrapthemes.co/" target="_blank">BootstrapThemes</a></div>
                    <a href="#" class="scrollToTop"><i class="pe-7s-up-arrow pe-va"></i></a>
                </div>	
            </div>	
        </footer>

        <!-- /.javascript files -->
        <script src="{{ URL::asset('js/jquery.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('js/custom.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.sticky.js') }}"></script>
        <script src="{{ URL::asset('js/wow.min.js') }}"></script>
        <script src="{{ URL::asset('js/owl.carousel.min.js') }}"></script>
        <script>
             new WOW().init();
        </script>
    </body>
</html>