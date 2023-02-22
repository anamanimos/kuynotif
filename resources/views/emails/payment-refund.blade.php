<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{$data['product_title']}} - Pembayaran dikembalikan</title>
</head>

<body>
    Halo {{$data['customer']['full_name']}},<br/>
    Pembayaran untuk Invoice <strong>{{$data['invoice']}}</strong> telah dikembalikan. Detail Booking:<br/><br/>

    Nama : {{$data['customer']['full_name']}}<br/>
    Email : {{$data['customer']['email']}}<br/>
    WhatsApp :{{$data['customer']['whatsapp']}}<br/><br/>

    Produk : {{$data['product_title']}}<br/>
    Hari, Tanggal : {{$data['booking_date']}}<br/>
    Waktu : {{$data['booking_time']}}<br/><br/>

    Jumlah dibayarkan:{{$data['total_payment']}}<br/><br/>
</body>

</html>