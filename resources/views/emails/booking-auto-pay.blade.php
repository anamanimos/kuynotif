<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuy Studio</title>
</head>

<body>
    Halo {{$data['customer']['full_name']}},<br/>   
    Booking {{$data['product_title']}} berhasil. Detail Booking:<br/><br/>

    Nomor Invoice <strong>{{$data['invoice']}}</strong><br/><br/>
    Nama : {{$data['customer']['full_name']}}<br/>
    Email : {{$data['customer']['email']}}<br/>
    WhatsApp :{{$data['customer']['whatsapp']}}<br/><br/>

    Hari, Tanggal : {{$data['booking_date']}}<br/>
    Waktu : {{$data['booking_date']}}<br/><br/>
    
    <?php if($data['booking_option'] != ''){ ?>
        @foreach ($data['booking_option'] as $option)
            {{$option['name']}} : {{$option['value']}}<br/>
        @endforeach
    <?php } ?>
    <br/><br/>

    Jumlah harus dibayarkan:{{$data['total_payment']}}<br/><br/>

    Silahkan lakukan pembayaran pada halaman website, atau melalui link berikut ini <a href='{{$data['checkout_url']}}'>Bayar Sekarang</a><br/>
    Booking akan otomatis batal apabila kamu tidak melakukan pembayaran dalam jangka waktu 30 menit.
</body>

</html>