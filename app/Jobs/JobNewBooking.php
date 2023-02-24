<?php

namespace App\Jobs;

use App\Mail\BookingAutoPay;
use Illuminate\Bus\Queueable;
use App\Mail\BookingManualPay;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Send as ModelsSend;

class JobNewBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $send = new ModelsSend();
        $mailer = $send->mailer('newbooking', $this->data);
        if ($mailer['success'] == true) {
            $mail = 'SENDED';
            $mail_before = 'yes';
        } else {
            $mail = 'NOT SENDED';
            $mail_before = 'no';
        }
        $data_modif = $this->data;

        // Send callback
        $data_send = [
            'invoice' => $this->data['invoice'],
            'mail_before' => $mail_before
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://dev-app.kuystudio.test/api/callback/notif',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data_send),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_SSL_VERIFYPEER  => false,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $data_modif['mail_status'] = $mail;

        $send->telegramNewBooking($data_modif);
    }
}
