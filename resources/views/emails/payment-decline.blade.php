<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuy Studio - Pembayaran ditolak</title>
</head>

<body>
    Halo {{$data['customer']['full_name']}}, Pembayaran Booking untuk invoice <strong>{{$data['invoice']}}</strong> tidak valid.<br/><br/>
    Bila kamu sudah merasa membayar silahkan ulangin proses Konfirmasi pembayaran dan pastikan kamu mengupload bukti transfer dengan benar. <br/><br/><a href="{{$data['checkout_url']}}">Konfirmasi Pembayaran</a>
</body>

</html>