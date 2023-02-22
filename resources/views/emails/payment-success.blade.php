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
    Pembayaran untuk Invoice <strong>{{$data['invoice']}}</strong> telah diterima. Detail Booking:<br/><br/>

    Nama : {{$data['customer']['full_name']}}<br/>
    Email : {{$data['customer']['email']}}<br/>
    WhatsApp :{{$data['customer']['whatsapp']}}<br/><br/>

    Produk : {{$data['product_title']}}<br/>
    Hari, Tanggal : {{$data['booking_date']}}<br/>
    Waktu : {{$data['booking_time']}}<br/><br/>

    Jumlah dibayarkan:{{$data['total_payment']}}<br/><br/>
    
    Cek detail Bookingmu disini <a href='{{$data['checkout_url']}}'>DETAIL BOOKING</a><br/><br/>

    Kuy Studio merupakan sebuah tempat dimana kalian dapat merasakan pengalaman baru dalam berfoto tanpa kehadiran seorang fotografer!<br/>
    * UNLIMITED Person!<br/>
    * UNLIMITED Photos!<br/>
    * 15 Minutes Photoshoot<br/>
    * 5 Minutes Photo Selection<br/>
    * Free 2 Props<br/>
    * Free ALL COLOR Softcopy*<br/><br/>

    Terms and Conditions:<br/>
    * Re-Schedule maksimal H-1 untuk 1x kesempatan<br/>
    * Reschedule di hari H (sebelum jam kedatangan) akan mengikuti slot kosong di hari tersebut (apabila masih tersedia / hangus)<br/>
    * Keterlambatan maksimal 5 menit / waktu akan terpotong secara otomatis<br/>
    * Disarankan datang 10 menit lebih awal untuk touch up / persiapan<br/>
    * Follow IG + Tag Story @kuystudio + Google review akan mendapatkan GRATIS ALL COLOR Softcopy melalui Drive<br/><br/>

    See you :).
</body>

</html>