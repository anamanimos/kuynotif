<?php

namespace App\Jobs;

use App\Mail\PaymentExpired;
use Illuminate\Bus\Queueable;
use App\Models\Send as ModelsSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class JobPaymentExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if (Mail::to($this->request['customer']['email'])->send(new PaymentExpired($this->data))) {
            $mail = 'SENDED';
            $mail_after = 'yes';
        } else {
            $mail = 'NOT SENDED';
            $mail_after = 'no';
        }
        $data_modif = $this->data;

        // Send callback
        $data_send = [
            'invoice' => $this->data['invoice'],
            'mail_after' => $mail_after
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

        $data_modif['title'] = 'BOOKING - Payment Expired';
        $data_modif['mail_status'] = $mail;
        $send = new ModelsSend();
        $send->telegram($data_modif);
    }
}
