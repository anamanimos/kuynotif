<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuy Studio - Konfirmasi Pembayaran diterima</title>
</head>

<body>
    Halo {{$data['customer']['full_name']}},<br/>
    Konfirmasi pembayaran untuk Booking {{$data['product_title']}} dengan Nomor Invoice <strong style="color:#FF0000">{{$data['invoice']}}</strong> telah diterima. Mohon tunggu beberapa saat untuk approval oleh admin KuyStudio.<br/><br/>

    Informasi approval akan dikirimkan melalui email atau kamu dapat melihat status pembayaran pada link berikut ini: <a href="{{$data['checkout_url']}}">Status Pembayaran</a>
</body>

</html>