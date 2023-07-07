<!DOCTYPE html>
<!--
Template Name: Foxclore
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Copyright: OS-Templates.com
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<html lang="">
<!-- To declare your language - read more here: https://www.w3.org/International/questions/qa-html-language-declarations -->
<head>
<title>Homepage | Masjid Darul Ulum Universitas Pamulang</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ URL::asset('css/layout.css') }}" rel="stylesheet" type="text/css" media="all">
<link href="{{ URL::asset('css/modified.css') }}" rel="stylesheet" type="text/css" media="all">
<link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay hero" style="background-image:url('https://www.free-css.com/assets/files/free-css-templates/preview/page271/foxclore/images/live-demo/background-01.jpg');"> 
  <!-- ################################################################################################ -->
  <header id="header" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div id="logo" class="one_quarter first">
      <h1><a href="index.html">Masjid</a></h1>
      <p>DARUL ULUM UNIVERSITAS PAMULANG</p>
    </div>
    <div class="three_quarter">
      <ul class="nospace clear">
        <li class="one_third first">
          <div class="block clear"><a href="#"><i class="fas fa-phone"></i></a> <span><strong>Telepon:</strong> 085719448568</span></div>
        </li>
        <li class="one_third">
          <div class="block clear"><a href="#"><i class="fas fa-envelope"></i></a> <span><strong>Email:</strong> upz@unpam.com</span></div>
        </li>
        <li class="one_third">
          <div class="block clear"><a href="#"><i class="fas fa-clock"></i></a> <span><strong> Sen. - Sel.:</strong> 08.00 - 18.00</span></div>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </header>
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <section id="navwrapper" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <nav id="mainav">
      <ul class="clear">
        <li class="active"><a href="index.html">Beranda</a></li>
        <li><a class="drop" href="#">Jurnal</a>
          <ul>
			@foreach ($categories as $key => $value)
            	<li><a href="pages/font-icons.html">{{ $value }}</a></li>
			@endforeach
          </ul>
        </li>
		<li><a class="drop" href="#">Program</a>
			<ul>
			  @foreach ($programs as $key => $value)
				  <li><a href="pages/font-icons.html">{{ $value }}</a></li>
			  @endforeach
			</ul>
		</li>	
        <li><a class="drop" href="#">Pembayaran</a>
          <ul>
			@foreach ($transaction_type as $transaction_item)
            	<li><a href="pages/font-icons.html">{{ $transaction_item->name }}</a></li>
			@endforeach
          </ul>
        </li>
		
        <li><a href="#">Konfirmasi Pembayaran</a></li>
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </section>
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <div id="pageintro" class="hoc clear slider"> 
	<div class="slide">
		<article>
			<h3 class="title"  id="title" data-wow-duration="1s">Magna feugiat pulvinar</h3>
			<p id="subtitle" data-wow-duration="1s">At dapibus ac velit cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus maecenas ut</p>
			<footer>
				<a class="btn" id="btn" href="">Klik Ini</a>
			</footer>
		</article>
	</div>
    <!-- ################################################################################################ -->
    
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <section id="introblocks">
      <ul class="nospace group">
		@foreach($posts as $post)
        <li class="one_third">
          <figure>
			<a class="imgover" href="#">
				<img src="{{ $post->banner }}" alt="">
			</a>
            <figcaption>
              <h6 class="heading">{{ read_more($post->title, 100) }}</h6>
              <p>{!! read_more(html_entity_decode($post->content), 100) !!}</p>
            </figcaption>
          </figure>
        </li>
		@endforeach
      </ul>
    </section>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row2">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <p class="nospace font-xs">Jenis Kegiatan</p>
      <h6 class="heading">Daftar kegiatan</h6>
    </div>
    <ul class="nospace group center activity">
	@foreach ($activity as $index => $item )
      <li class="one_third <?php echo $index == 0 ? 'first' : '' ?>">
        <article>
			<img src="{{ $item->icon }}" alt="">
          <h6 class="heading"> {{ $item->name }} </h6>
          <p class="btmspace-30">{!! read_more($item->description, 100) !!}</p>
        </article>
      </li>
	@endforeach
    </ul>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <section class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <p class="nospace font-xs">Keuanga</p>
      <h6 class="heading">Rangkuman Laporan Keuangan</h6>
    </div>
    <ul id="stats" class="nospace group">
      <li><i class="fas fa-id-badge"></i>
        <p><a href="#">{{ $summary_transaction['month']['in'] }}</a></p>
        <p>Total dana masuk bulan ini</p>
      </li>
      <li><i class="fas fa-inbox"></i>
        <p><a href="#">{{ $summary_transaction['month']['out'] }}</a></p>
        <p>Totan dana keluar bulan ini</p>
      </li>
     
      <li><i class="fas fa-store-alt"></i>
        <p><a href="#">{{ $summary_transaction['total'] }}</a></p>
        <p>Semua Dana Terkumpul</p>
      </li>
    </ul>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper coloured">
  <section id="testimonials" class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <p class="nospace font-xs">Struktur Organisasi</p>
      <h6 class="heading">Keanggotaan Masjid Darul Ulum Universitas Pamulang</h6>
    </div>
	<div class="organization">
		@foreach($structure as $item)
		<div class="item">
			<img width="100" height="100" alt="" src="{{ $item->avatar }}">
			<h6 class="heading">{{ $item->name }}</h6>
			<em>{{ $item->title }}</em>
		</div>
		@endforeach
	</div>
    {{--<article class="one_half first"><img width="100" height="100" alt="">
      <h6 class="heading">J. Doe</h6>
      <em>Nulla mauris hendrerit</em></article>
    <article class="one_half"><img src="images/demo/100x100.png" alt="">
      <h6 class="heading">G. Doe</h6>
      <em>Aenean vestibulum mattis</em></article>

	  <article class="one_half"><img src="images/demo/100x100.png" alt="">
		<h6 class="heading">G. Doe</h6>
		<em>Aenean vestibulum mattis</em></article>--}}
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="bgded overlay row4" style="background-image:url('images/demo/backgrounds/01.png');">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="center btmspace-50">
      <h6 class="heading">Masjid DARUL ULUM</h6>
   
      <p class="nospace">UNIVERSITAS PAMULANG KAMPUS VIKTOR</p>
    </div>
    <!-- ################################################################################################ -->
    <hr class="btmspace-50">
    <!-- ################################################################################################ -->
    <div class="three_quarter first">
      <h6 class="heading">Ingin mengirim pesan ?</h6>
      <p class="nospace btmspace-15">Kirimkan pesan</p>
      <form action="#" method="post">
        <fieldset>
          <legend>Pesan:</legend>
          <input class="btmspace-15" type="text" value="" placeholder="Nama">
          <textarea class="btmspace-15" rows="10" cols="100"></textarea>
          <button type="submit" value="submit">Submit</button>
        </fieldset>
      </form>
    </div>
    
    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Domain Name</a></p>
    <p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.backtotop.js') }}"></script>
<script src="{{ URL::asset('js/jquery.mobilemenu.js') }}"></script>
<script src="{{ URL::asset('js/wow.min.js') }}"></script>
<script type="text/javascript">
	new WOW().init();
	$.ajax({
		url: '{{ route('banner') }}', // Replace with your API endpoint
		method: 'GET',
		dataType: 'json', // Set the expected data type
		success: function(response) {
			// Handle the successful response
			const heroes = response.data
			let currentIndex = 0;
			function updateHeroes(item)
			{
				const wow = new WOW()
				const element = ['title', 'subtitle'];
				element.forEach(eachElement => {
					const div = $('.slide').find(`#${eachElement}`)
					div.html(item[eachElement])
					$('#btn').attr('href', item.link)
					if (item.link == '')
					{
						$('#btn').hide()
					}					
					$('.hero').css({
						'background-image': `url(${item.image})`
					})
				})
				console.log($('.slide').find('#content'))
				console.log($('.slide').find('#btn'))
			}
			function showSlide(currentIndex) 
			{	
				heroes.forEach((item, index) => {
					if (currentIndex == index) updateHeroes(item)
				});
			}
			function nexSlide() 
			{
				currentIndex = (currentIndex + 1) % heroes.length;
				showSlide(currentIndex);
			}
			showSlide(currentIndex)
			setInterval(nexSlide, 5000);
		},
		error: function(xhr, status, error) {
			// Handle the error
			console.log('Error:', error);
		}
	});
</script>
</body>
</html>