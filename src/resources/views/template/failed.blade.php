<img src="{{ URL::asset('img/icon/failed.png') }}" alt="">
<h2>Mohon maaf tidak bisa melanjutkan pembayaran, silahkan coba lakukan pembayaran ulang!.</h2>
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