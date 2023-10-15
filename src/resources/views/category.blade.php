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
<style type="text/css">
	.wrapper {
		background-color: #fbfbfb !important;
	}
</style>
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
      <h1><a href="{{ route('homepage') }}">Masjid</a></h1>
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
        <li class="{{ route_name() == 'homepage' ? 'active' : '' }}"><a href="{{ route('homepage') }}">Beranda</a></li>
        <li class="{{ route_name() == 'categories' ? 'active' : '' }}"><a class="drop" href="#">Jurnal</a>
          <ul>
			@foreach ($categories as $key => $value)
				@php
					$hashed_id = \Illuminate\Support\Facades\Crypt::encryptString($key.'_'.$value);
				@endphp
            	<li><a href="{{ route('categories', ['id' => $hashed_id]) }}">{{ $value }}</a></li>
			@endforeach
          </ul>
        </li>
		<li class="{{ route_name() == 'program' ? 'active' : '' }}"><a class="drop" href="#">Program</a>
			<ul>
			  @foreach ($programs as $key => $value)
			  @php
			  	$hashed_id = \Illuminate\Support\Facades\Crypt::encryptString($key.'_'.$value);
		 	  @endphp
		  	 <li><a href="{{ route('program', ['id' => $hashed_id]) }}">{{ $value }}</a></li>
			  @endforeach
			</ul>
		</li>	
       
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
			<h3 class="title" >{{ $page }}</h3>
			<p>{{ $category_name }}</p>
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
			<img src="{{ $post->banner }}" alt="">
            <figcaption>
				@php
					$hashed_id = \Illuminate\Support\Facades\Crypt::encryptString($post->id.'_'.$post->title);
					$route = 'detail.categories';
					if (in_array($post->category, array_values(\App\Util\Common::getPrograms())))
						$route = 'detail.program';
				@endphp
              <a href="{{ route($route, ['id' => $hashed_id]) }}" class="heading" style="color: black;">{{ read_more($post->title, 100) }}</a>
              <p>{!! read_more(html_entity_decode($post->content), 100) !!}</p>
            </figcaption>
          </figure>
        </li>
		@endforeach
      </ul>
    </section>
	@if (count($posts) == 0)
	<section class="detail">
		<h2 class="notfound"><?php echo 'Tidak ada ' . $page . ' dengan pilihan ' ?> <span style="color: #41C379"><?php echo $category_name ?></span></h2>
	</section>
	@endif
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

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