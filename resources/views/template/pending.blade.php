<img src="{{ URL::asset('img/icon/pending.png') }}" alt="">
<h2>Transaksi kamu berhasil kami buat silahkan, status transaksi anda PENDING, 
	silahkan refresh secara berkala halaman ini jika kamu merasa sudah membayar atau jika belum silahkan selesaikan pembayaran tersebut dilink di bawah ini, Terimakasih.</h2>
<table>
	<tr>
		<td>Jenis Pembayaran</td>
		<td>{{ $transaction_type_record->name }}</td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>{{ $transaction_record->customer->name }}</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>{{ $transaction_record->customer->email }}</td>
	</tr>
	<tr>
		<td>Telepone</td>
		<td>{{ $transaction_record->customer->phone_number }}</td>
	</tr>
	<tr>
		<td>Metode Pembayaran</td>
		<td>{{ $transaction_record->payment->name }}</td>
	</tr>
	<tr>
		<td>Status Pembayaran</td>
		<td>{{ $transaction_status_name }}</td>
	</tr>
</table>
<a href="{{ $transaction_record->redirect_payment }}" target="__blank" class="btn">Bayar</a>