<?php

namespace App\Models;

use App\Mail\PaymentFailed;
use App\Mail\PaymentRefund;
use App\Mail\BookingAutoPay;
use App\Mail\PaymentConfirm;
use App\Mail\PaymentExpired;
use App\Mail\PaymentSuccess;
use App\Mail\BookingManualPay;
use App\Mail\PaymentDecline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Send extends Model
{
    use HasFactory;

    public static function mailer($type, $data)
    {
        $router = DB::table('settings')->where('name', 'email_router')->value('value');
        if ($router == 0) {
            $new_value = 1;
            if ($type == 'newbooking') {
                if ($data['type'] == 'manual') {
                    if (Mail::to($data['customer']['email'])->send(new BookingManualPay($data))) {
                        $send = true;
                    } else {
                        $send = false;
                    }
                } elseif ($data['type'] == 'auto') {
                    if (Mail::to($data['customer']['email'])->send(new BookingAutoPay($data))) {
                        $send = true;
                    } else {
                        $send = false;
                    }
                }
            } elseif ($type == 'paymentconfirm') {
                if (Mail::to($data['customer']['email'])->send(new PaymentConfirm($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentdecline') {
                if (Mail::to($data['customer']['email'])->send(new PaymentDecline($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentexpired') {
                if (Mail::to($data['customer']['email'])->send(new PaymentExpired($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentfailed') {
                if (Mail::to($data['customer']['email'])->send(new PaymentFailed($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentrefund') {
                if (Mail::to($data['customer']['email'])->send(new PaymentRefund($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentsuccess') {
                if (Mail::to($data['customer']['email'])->send(new PaymentSuccess($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } else {
                $send = false;
            }
        } else {
            $new_value = 0;
            if ($type == 'newbooking') {
                if ($data['type'] == 'manual') {
                    if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new BookingManualPay($data))) {
                        $send = true;
                    } else {
                        $send = false;
                    }
                } elseif ($data['type'] == 'auto') {
                    if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new BookingAutoPay($data))) {
                        $send = true;
                    } else {
                        $send = false;
                    }
                }
            } elseif ($type == 'paymentconfirm') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentConfirm($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentdecline') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentDecline($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentexpired') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentExpired($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentfailed') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentFailed($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentrefund') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentRefund($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } elseif ($type == 'paymentsuccess') {
                if (Mail::mailer('smtp2')->to($data['customer']['email'])->send(new PaymentSuccess($data))) {
                    $send = true;
                } else {
                    $send = false;
                }
            } else {
                $send = false;
            }
        }
        // update
        DB::table('settings')->where('name', 'email_router')->update(['value' => $new_value, 'updated_at' => date("Y-m-d H:i:s")]);

        return ['success' => $send];
    }
    public static function telegram($data)
    {
        $message = '*' . $data['title'] . '*
    
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
        $message = '*' . $data['title'] . '*
    
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
        $send->telegram_attach($data['image'], $message);
    }

    public static function telegramNewBooking($data)
    {
        $notif_option = '';
        if ($data['booking_option'] != '') {
            foreach ($data['booking_option'] as $option) {
                $notif_option .= $option['name'] . ' : ' . $option['value'] . '
';
            }
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
