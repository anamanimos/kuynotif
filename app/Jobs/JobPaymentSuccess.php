<?php

namespace App\Jobs;

use App\Mail\PaymentSuccess;
use Illuminate\Bus\Queueable;
use App\Models\Send as ModelsSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class JobPaymentSuccess implements ShouldQueue
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $send = new ModelsSend();
        $mailer = $send->mailer('paymentsuccess', $this->data);
        if ($mailer['success'] == true) {
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

        $data_modif['title'] = 'BOOKING - Payment Complete';
        $data_modif['mail_status'] = $mail;

        if ($send->telegram($data_modif)) {
            $telegram_send = true;
        } else {
            $telegram_send = false;
        };

        echo json_encode(['email' => $mail, 'telegram' => $telegram_send]);
    }
}
