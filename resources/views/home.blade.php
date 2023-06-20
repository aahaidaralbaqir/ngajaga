<!DOCTYPE html>
<html>
    <head>

        <!-- /.website title -->
        <title>Homepage</title>
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

        <!-- /.parallax full screen background image -->
        <div class="fullscreen landing parallax" style="background-image:url('https://images7.alphacoders.com/111/1117529.jpg');" data-img-width="2000" data-img-height="1333" data-diff="100">

            <div class="overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">

                            <!-- /.logo -->
                            <!-- /.main title -->
                            <h1 class="wow fadeInLeft">
                               Selamat datang di Masjid Darul Ulum
                            </h1>

                            <!-- /.header paragraph -->
                            <div class="landing-text wow fadeInUp">
                                <p>Terima kasih atas kunjungan sahabat muslim & muslimah semua semoga dengan adanya website ini mempermudah kami dalam melayani anda  dalam ibadah dan terjalin silataruhami.</p>
                            </div>

                        </div> 

                        <!-- /.signup form -->
                        <div class="col-md-5">

                            <div class="signup-header wow fadeInUp">
                                <h3 class="form-title text-center">BAYAR INFAQ ATAU ZAKAT</h3>
                                {{ Form::open(['route' => 'transaction.create', 'method' => 'POST', 'class' => 'form-header']); }}
                                    <div class="form-group">
                                        <select name="id_transaction_type" id="" class="form-control input-lg">
                                            <option value="0">Pilih Kategori</option>
                                            @foreach ($transaction_type as $transaction)
                                                <option value="{{ $transaction->id }}">{{ $transaction->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_transaction_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-lg" name="name" type="text" placeholder="Nama kamu" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-lg" name="email" type="emai" placeholder="Email kamu" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="LANJUTKAN">
                                    </div>
                                {{ Form::close() }}
                            </div>				

                        </div>
                    </div>
                </div> 
            </div> 
        </div>

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

        <!-- /.intro section -->
        <div id="intro">
            <div class="container">
                <div class="row">

                    <!-- /.intro image -->
                    <div class="col-md-6 intro-pic wow slideInLeft">
                        <img src="https://berita.99.co/wp-content/uploads/2021/04/Masjid-Unik-darul-ulum-unpam.jpg" alt="image" class="img-responsive">
                    </div>	

                    <!-- /.intro content -->
                    <div class="col-md-6 wow slideInRight">
                        <h2>Profile Masjid</h2>
                        <p>
                            Masjid Al-Mustafa adalah sebuah masjid yang didirikan pada tahun 2010 dengan tujuan menyediakan tempat ibadah dan memperkuat hubungan antarumat Muslim dalam komunitas setempat. Masjid ini terletak di lingkungan yang damai dan mudah diakses oleh warga sekitar.
                        </p>

                        <div class="btn-section"><a href="#feature" class="btn-default">Baca lebih lanjut</a></div>

                    </div>
                </div>			  
            </div>
        </div>

        <!-- /.feature section -->
        <div id="feature">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center feature-title">

                        <!-- /.feature title -->
                        <h2>Kegiatan</h2>
                        <p>Kegiatan yang menjadi rutinitas di Masjid Darul Ulum.</p>
                    </div>
                </div>
                <div class="row row-feat">
                    <div class="col-md-12">

                        <!-- /.feature 1 -->
                        <div class="col-sm-6 feat-list">
                            <i class="pe-7s-notebook pe-5x pe-va wow fadeInUp"></i>
                            <div class="inner">
                                <h4>Shalat Lima Waktu</h4>
                                <p>Masjid Al-Mustafa menyelenggarakan shalat lima waktu secara teratur dan mengundang jamaah untuk berpartisipasi.
                                </p>
                            </div>
                        </div>

                        <!-- /.feature 2 -->
                        <div class="col-sm-6 feat-list">
                            <i class="pe-7s-cash pe-5x pe-va wow fadeInUp" data-wow-delay="0.2s"></i>
                            <div class="inner">
                                <h4>Kajian Keagamaan</h4>
                                <p>Terdapat kajian keagamaan rutin yang dilaksanakan di masjid ini, termasuk tafsir Al-Quran, hadits, dan topik-topik lain yang relevan.</p>
                            </div>
                        </div>

                        <!-- /.feature 3 -->
                        <div class="col-sm-6 feat-list">
                            <i class="pe-7s-cart pe-5x pe-va wow fadeInUp" data-wow-delay="0.4s"></i>
                            <div class="inner">
                                <h4>Pengajian Anak-anak</h4>
                                <p>Masjid ini juga mengadakan pengajian khusus untuk anak-anak agar mereka dapat belajar tentang ajaran Islam secara interaktif dan menyenangkan.</p>
                            </div>
                        </div>

                        <!-- /.feature 4 -->
                        <div class="col-sm-6 feat-list">
                            <i class="pe-7s-users pe-5x pe-va wow fadeInUp" data-wow-delay="0.6s"></i>
                            <div class="inner">
                                <h4>Bakti Sosial</h4>
                                <p>Masjid Al-Mustafa aktif dalam berbagai kegiatan bakti sosial, termasuk program pemberian makanan kepada yang membutuhkan, pembagian sembako, dan bantuan kebencanaan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.feature 2 section -->
        <div id="feature-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between" style="display: flex; justify-content: space-between;">
                        <h2>Jadwal Solat</h2>
                        <div class="dropdown" id="pilih-kegiatana"> 
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Pilih Kegiatan
                            </a>
                          
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 feature-2-pic wow fadeInLeft">
                        <img src="https://umsb.ac.id/upload/berita/Sujud.jpg" alt="macbook" class="img-responsive">
                    </div>
                    <div class="col-md-8 wow fadeInRight">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waku Berakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Solat Ashar</td>
                                    <td>13.00 WIB</td>
                                    <td>14.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- /.feature image -->
                    				  
                </div>			  

            </div>
        </div>


        <!-- /.download section -->
        <div id="download">
            <div class="action fullscreen parallax" style="background-image:url('images/bg.jpg');" data-img-width="2000" data-img-height="1333" data-diff="100">
                <div class="overlay">
                    <div class="container">
                        <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">

                            <!-- /.download title -->
                            <h2 class="wow fadeInRight">Would like to know more?</h2>
                            <p class="download-text wow fadeInLeft">We'll research the market, identify the right target audience, analyze competitors and avoid users churn to increase retention. Download now for free and join with thousands happy clients.</p>

                            <!-- /.download button -->
                            <div class="download-cta wow fadeInLeft">
                                <a href="#contact" class="btn-secondary">Get Connected</a>
                            </div>
                        </div>	
                    </div>	
                </div>
            </div>
        </div>

        <!-- /.pricing section -->
        <div id="package">
            <div class="container">
                <div class="text-center">

                    <!-- /.pricing title -->
                    <h2 class="wow fadeInLeft">PACKAGES</h2>
                    <div class="title-line wow fadeInRight"></div>
                </div>
                <div class="row package-option">

                    <!-- /.package 1 -->
                    <div class="col-sm-3">
                        <div class="price-box wow fadeInUp">
                            <div class="price-heading text-center">

                                <!-- /.package icon -->
                                <i class="pe-7s-radio pe-5x"></i>

                                <!-- /.package name -->
                                <h3>Basic</h3>
                            </div>

                            <!-- /.price -->
                            <div class="price-group text-center">
                                <span class="dollar">$</span>
                                <span class="price">9</span>
                                <span class="time">/mo</span>
                            </div>

                            <!-- /.package features -->
                            <ul class="price-feature text-center">
                                <li><strong>100MB</strong> Disk Space</li>
                                <li><strong>200MB</strong> Bandwidth</li>
                                <li><strong>2</strong> Subdomains</li>
                                <li><strong>5</strong> Email Accounts</li>
                                <li><strike>Webmail Support</strike></li>				  
                            </ul>

                            <!-- /.package button -->
                            <div class="price-footer text-center">
                                <a class="btn btn-price" href="#">BUY NOW</a>
                            </div>	
                        </div>
                    </div>

                    <!-- /.package 2 -->
                    <div class="col-sm-3">
                        <div class="price-box wow fadeInUp" data-wow-delay="0.2s">
                            <div class="price-heading text-center">

                                <!-- /.package icon -->
                                <i class="pe-7s-joy pe-5x"></i>

                                <!-- /.package name -->
                                <h3>Standard</h3>
                            </div>

                            <!-- /.price -->
                            <div class="price-group text-center">
                                <span class="dollar">$</span>
                                <span class="price">19</span>
                                <span class="time">/mo</span>
                            </div>

                            <!-- /.package features -->
                            <ul class="price-feature text-center">
                                <li><strong>300MB</strong> Disk Space</li>
                                <li><strong>400MB</strong> Bandwidth</li>
                                <li><strong>5</strong> Subdomains</li>
                                <li><strong>10</strong> Email Accounts</li>
                                <li><strike>Webmail Support</strike></li>			  
                            </ul>

                            <!-- /.package button -->
                            <div class="price-footer text-center">
                                <a class="btn btn-price" href="#">BUY NOW</a>
                            </div>
                        </div>
                    </div>	

                    <!-- /.package 3 -->
                    <div class="col-sm-3">
                        <div class="price-box wow fadeInUp" data-wow-delay="0.4s">
                            <div class="price-heading text-center">

                                <!-- /.package icon -->
                                <i class="pe-7s-science pe-5x"></i>

                                <!-- /.package name -->
                                <h3>Advance</h3>
                            </div>

                            <!-- /.price -->
                            <div class="price-group text-center">
                                <span class="dollar">$</span>
                                <span class="price">29</span>
                                <span class="time">/mo</span>
                            </div>

                            <!-- /.package features -->
                            <ul class="price-feature text-center">
                                <li><strong>1GB</strong> Disk Space</li>
                                <li><strong>1GB</strong> Bandwidth</li>
                                <li><strong>10</strong> Subdomains</li>
                                <li><strong>25</strong> Email Accounts</li>
                                <li>Webmail Support</li>					  
                            </ul>

                            <!-- /.package button -->
                            <div class="price-footer text-center">
                                <a class="btn btn-price" href="#">BUY NOW</a>
                            </div>	
                        </div>
                    </div>

                    <!-- /.package 4 -->
                    <div class="col-sm-3">
                        <div class="price-box wow fadeInUp" data-wow-delay="0.6s">
                            <div class="price-heading text-center">

                                <!-- /.package icon -->
                                <i class="pe-7s-tools pe-5x"></i>

                                <!-- /.package name -->
                                <h3>Ultimate</h3>
                            </div>

                            <!-- /.price -->
                            <div class="price-group text-center">
                                <span class="dollar">$</span>
                                <span class="price">49</span>
                                <span class="time">/mo</span>
                            </div>

                            <!-- /.package features -->
                            <ul class="price-feature text-center">
                                <li><strong>5GB</strong> Disk Space</li>
                                <li><strong>5GB</strong> Bandwidth</li>
                                <li><strong>50</strong> Subdomains</li>
                                <li><strong>50</strong> Email Accounts</li>
                                <li>Webmail Support</li>			  
                            </ul>

                            <!-- /.package button -->
                            <div class="price-footer text-center">
                                <a class="btn btn-price" href="#">BUY NOW</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- /.client section -->
        <div id="client"> 
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img alt="client" src="images/client1.png" class="wow fadeInUp">
                        <img alt="client" src="images/client2.png" class="wow fadeInUp" data-wow-delay="0.2s">
                        <img alt="client" src="images/client3.png" class="wow fadeInUp" data-wow-delay="0.4s">
                        <img alt="client" src="images/client4.png" class="wow fadeInUp" data-wow-delay="0.6s">
                    </div>
                </div>
            </div>	
        </div>

        <!-- /.testimonial section -->
        <div id="testi">
            <div class="container">
                <div class="text-center">
                    <h2 class="wow fadeInLeft">TESTIMONIALS</h2>
                    <div class="title-line wow fadeInRight"></div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">	
                        <div id="owl-testi" class="owl-carousel owl-theme wow fadeInUp">

                            <!-- /.testimonial 1 -->
                            <div class="testi-item">
                                <div class="client-pic text-center">

                                    <!-- /.client photo -->
                                    <img src="images/testi1.png" alt="client">
                                </div>
                                <div class="box">

                                    <!-- /.testimonial content -->
                                    <p class="message text-center">"We are very happy and satisfied with Backyard service. Our account manager is efficient and very knowledgeable. It was able to create a vast fan base within very short period of time. We would highly recommend Backyard App to anyone."</p>
                                </div>
                                <div class="client-info text-center">

                                    <!-- /.client name -->
                                    Jennifer Lopez, <span class="company">Microsoft</span>	
                                </div>
                            </div>		

                            <!-- /.testimonial 2 -->
                            <div class="testi-item">
                                <div class="client-pic text-center">

                                    <!-- /.client photo -->
                                    <img src="images/testi2.png" alt="client">
                                </div>
                                <div class="box">

                                    <!-- /.testimonial content -->
                                    <p class="message text-center">"Everything looks great... Thanks for the quick revision turn around. We were lucky to find you guys and will definitely be using some of your other services in the near future."</p>
                                </div>
                                <div class="client-info text-center">

                                    <!-- /.client name -->
                                    Mike Portnoy, <span class="company">Dream Theater</span>	
                                </div>
                            </div>				

                            <!-- /.testimonial 3 -->
                            <div class="testi-item">
                                <div class="client-pic text-center">

                                    <!-- /.client photo -->
                                    <img src="images/testi3.png" alt="client">
                                </div>
                                <div class="box">

                                    <!-- /.testimonial content -->
                                    <p class="message text-center">"Overall, the two reports were very clear and helpful so thank you for the suggestion to do the focus group. We are currently working with our developer to implement some of these suggestions."</p>
                                </div>
                                <div class="client-info text-center">

                                    <!-- /.client name -->
                                    Jennifer Love Hewitt, <span class="company">Lead Vocal</span>	
                                </div>
                            </div>			

                        </div>
                    </div>	
                </div>	
            </div>
        </div>

        <!-- /.contact section -->
        <div id="contact">
            <div class="contact fullscreen parallax" style="background-image:url('https://images7.alphacoders.com/111/1117529.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
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