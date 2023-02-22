<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    use HasFactory;

    public static function telegram($data)
    {
        $message = $data['title'] . '
    
Name : ' . $data['customer']['full_name'] . '
Email : ' . $data['customer']['email'] . '
WhatsApp : ' . $data['customer']['whatsapp'] . '
        
Invoice :*' . $data['invoice'] . '*
Booking Date : ' . $data['booking_date'] . '
Time : ' .  $data['booking_time'] . '

Payment Method : ' . $data['payment']['name'] . '
Payment Status : ' . $data['payment']['status'] . '
Mail status : ' . $data['mail_status'] . '
            
*Artspace Production*';

        $send = new Send();
        $send->telegram_text($message);
    }

    public static function telegramPaymentConfirm($data)
    {
        $message = $data['title'] . '
    
Name : ' . $data['customer']['full_name'] . '
Email : ' . $data['customer']['email'] . '
WhatsApp : ' . $data['customer']['whatsapp'] . '
        
Invoice :*' . $data['invoice'] . '*
Booking Date : ' . $data['booking_date'] . '
Time : ' .  $data['booking_time'] . '

Payment Method : ' . $data['payment']['name'] . '
Payment Status : ' . $data['payment']['status'] . '
Mail status : ' . $data['mail_status'] . '
            
*Artspace Production*';

        $send = new Send();
        $send->telegram_attach($data['image_confirm'], $message);
    }

    public static function telegramNewBooking($data)
    {
        $notif_option = '';
        foreach ($data['booking_option'] as $option) {
            $notif_option .= $option['name'] . ' : ' . $option['value'] . '
';
        }
        $message = '*NEW BOOKING*
    
Name : ' . $data['customer']['full_name'] . '
Email : ' . $data['customer']['email'] . '
WhatsApp : ' . $data['customer']['whatsapp'] . '

Invoice :*' . $data['invoice'] . '*
Product : ' . $data['product_title'] . '
Booking Date : ' . $data['booking_date'] . '
Time : ' . $data['booking_time'] . '

' . $notif_option . '
Payment Method : ' . $data['payment']['name'] . '
Payment Status : ' . $data['payment']['status'] . '
Payment URL : ' . $data['checkout_url'] . '
Mail status : ' . $data['mail_status'] . '
                
*Artspace Production*';

        $send = new Send();
        $send->telegram_text($message);
    }

    private function telegram_text($message)
    {
        $data = [
            'chat_id'       => env('TELEGRAM_CHAT_ID', '711526521'),
            'parse_mode'    => 'markdown',
            'text'          => $message
        ];
        file_get_contents('https://api.telegram.org/bot' . env('TELEGRAM_TOKEN', '5860936521:AAHgeU5SqPdA9qeFIEayK-B6U3jjfgydW7g') . '/sendMessage?' . http_build_query($data));
    }

    private function telegram_attach($doc, $message)
    {
        $doc = $doc;
        $split = explode('.', $doc);
        $count = count($split) - 1;

        if ($split[$count] == 'pdf') {
            $data = [
                'chat_id'       => env('TELEGRAM_CHAT_ID', '711526521'),
                'parse_mode'    => 'markdown',
                'document'      => $doc,
                'caption'       => $message
            ];
            file_get_contents('https://api.telegram.org/bot' . env('TELEGRAM_TOKEN', '5860936521:AAHgeU5SqPdA9qeFIEayK-B6U3jjfgydW7g') . '/sendDocument?' . http_build_query($data));
        } else {
            $data = [
                'chat_id'       => env('TELEGRAM_CHAT_ID', '711526521'),
                'parse_mode'    => 'markdown',
                'photo'         => $doc,
                'caption'       => $message
            ];
            file_get_contents('https://api.telegram.org/bot' . env('TELEGRAM_TOKEN', '5860936521:AAHgeU5SqPdA9qeFIEayK-B6U3jjfgydW7g') . '/sendPhoto?' . http_build_query($data));
        }
    }
}
