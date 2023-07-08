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
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-ztMsf3Pi7P5VyEgR"></script>
<style type="text/css">
	.wrapper {
		background-color: #fbfbfb !important;
	}
	.detail {
		margin: -200px auto 0px auto;
		width: 43%;
		padding: 30px 20px;
		box-sizing: border-box;
	}
	h1 {
		margin: 0px;
	}

	
	.w-payment {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 10px 0px 10px 0px;
		cursor: pointer;
	}
	.w-payment:not(:last-child) {
		border-bottom: 1px solid #d7d7d7;
	}
	.w-payment .w-information img {
		width: 30px;
	}
	.w-payment .w-information span {
		margin-left: 10px;
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
        <li class="{{ route_name() == 'detail.categories' ? 'active' : '' }}"><a class="drop" href="#">Jurnal</a>
          <ul>
			@foreach ($categories as $key => $value)
				@php
					$hashed_id = \Illuminate\Support\Facades\Crypt::encryptString($key.'_'.$value);
				@endphp
            	<li><a href="{{ route('categories', ['id' => $hashed_id]) }}">{{ $value }}</a></li>
			@endforeach
          </ul>
        </li>
		<li class="{{ route_name() == 'detail.program' ? 'active' : '' }}"><a class="drop" href="#">Program</a>
			<ul>
			  @foreach ($programs as $key => $value)
			  @php
			  	$hashed_id = \Illuminate\Support\Facades\Crypt::encryptString($key.'_'.$value);
		 	  @endphp
		  	 <li><a href="{{ route('program', ['id' => $hashed_id]) }}">{{ $value }}</a></li>
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
			<h3 class="title" >Pembayaran</h3>
			<p>{{ $transaction_type_record->name }}</p>
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
   
	<section class="detail">
		{{ Form::open(['route' => 'transaction.register', 'method' => 'POST', 'class' => 's-container form-header']); }}
		<div>
			<h1>Metode Pembayaran</h1>
			<small>Silahkan pilih metode pembayaran yang ingin digunakan</small>
			<hr>
			<input type="hidden" class="transaction-id" name="transaction_id" value="{{ $transaction_record->order_id }}">
			<div class="form-group">
				<div class="list">
					@foreach($payments as $parent_payment)
						@if (array_key_exists('childs', $parent_payment))
							<div class="card">
								<div class="card-body">
									<div class="form-group">
										<p>{{ $parent_payment['name'] }}</p>
									</div>
									<div class="form-group s-payment">
										@foreach($parent_payment['childs'] as $each_child)
											<div class="w-payment" id-payment="{{ $each_child['id'] }}">
												<div class="w-information">
													<img src="{{ $each_child['payment_logo'] }}" alt="">
													<span>{{ $each_child['name'] }}</span>
												</div>
												<input type="radio" id="id_payment_{{ $each_child['id'] }}" name="id_payment_type" value="{{ $each_child['id'] }}" >
											</div>
										@endforeach
									</div>
								</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		

			<div class="form-group" style="display: flex; gap: 20px">
				<button id="btn-back" style="background-color: #bcbcbc; color: black;" type="button" target-url="{{ route('transaction.checkout', ['transactionId' => $transaction_record->order_id]) }}">Kembali</button>
				<button type="button" id="btn-pay">Bayar</button>
			</div>	
		</div>
		{{ Form::close() }}
	</section>
	
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
	$(document).ready(function () {
		let paymentList = document.querySelectorAll('.w-payment')
		const btnBack = document.getElementById('btn-back')
		const btnPay = document.getElementById('btn-pay')
		new WOW().init();
		function unselectPayment() {
			paymentList.forEach(item => {
				let paymentId = item.getAttribute('id-payment')
				let radioButton = document.getElementById(`id_payment_${paymentId}`)
				if (radioButton.hasAttribute('checked'))
				{
					radioButton.removeAttribute('checked') 
				}
			}) 
		}
		function getSelectedPayment()
		{
			return 
		}
		paymentList.forEach(item => {
			item.addEventListener('click', function () {
				unselectPayment()
				let paymentId = this.getAttribute('id-payment')
				let radioButton = document.getElementById(`id_payment_${paymentId}`)
				radioButton.setAttribute('checked', true)
			})
		})
		btnBack.addEventListener('click', function () {
			let targetUrl = this.getAttribute('target-url')
			window.location = targetUrl  
		})
		function getToken()
		{
			const transactionId = $('.transaction-id').val()
			let paymentId = $('input[name="id_payment_type"]:checked').val();
			console.log(paymentId)
			if ([undefined, ''].includes(paymentId)) paymentId = 0
			const requestBody = {
				id_payment: paymentId,
				transaction_id: transactionId 
			}
			return fetch('/api/transaction/token', {
				method: "POST",
				body: JSON.stringify(requestBody),
				headers: {
					"Content-type": "application/json; charset=UTF-8",
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}).then(response => response.json())
			.then(result => result);
		}
		function notification(orderId)
		{
			const requestBody = {
				order_id: orderId 
			}
			return fetch('/api/transaction/notification', {
				method: "POST",
				body: JSON.stringify(requestBody),
				headers: {
					"Content-type": "application/json; charset=UTF-8",
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}).then(response => response.json())
			.then(result => result); 
		}
		btnPay.addEventListener('click', async function () {
			this.setAttribute('disabled', true)
			const response = await getToken()
			if (!response.success) {
				$('.error-message').html(response.message)
				$('.error-message').removeClass('hidden');
				$('html, body').animate({scrollTop : 0},800);
				this.removeAttribute('disabled')
				return;
			}
			this.removeAttribute('disabled')
			window.snap.pay(response.data, {
				onSuccess: async function(result){
					let {order_id} = result;
					const {success} = await notification(order_id)
					if (!success) return;
					window.location = '{{ route("transaction.complete", ["transactionId" => $transaction_record->order_id]) }}'
				},
				onPending: async function(result){
					let {order_id} = result;
					const {success} = await notification(order_id)
				},
				onError: async function(result){
					let {order_id} = result;
					const {success} = await notification(order_id)
				},
				onClose: async function(){
					let {order_id} = result;
					const {success} = await notification(order_id)
				}
			})
		})

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
	})
	
</script>
</body>
</html>