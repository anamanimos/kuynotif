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

class NewBooking implements ShouldQueue
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
        //

        if ($this->data['type'] == 'manual') {
            if (Mail::to($this->request['customer']['email'])->send(new BookingManualPay($this->data))) {
                $mail = 'SENDED';
                $mail_before = 1;
            } else {
                $mail = 'NOT SENDED';
                $mail_before = 0;
            }
        } elseif ($this->data['type'] == 'auto') {
            if (Mail::to($this->data['customer']['email'])->send(new BookingAutoPay($this->data))) {
                $mail = 'SENDED';
                $mail_before = 1;
            } else {
                $mail = 'NOT SENDED';
                $mail_before = 0;
            }
        }
        $data_modif = $this->data;

        // Send callback
        $data_send = [
            'invoice' => $data_modif['invoice'],
            'mail_before' => $mail_before,
            'mail_after' => 0
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
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);


        $data_modif['mail_status'] = $mail;
        $send = new ModelsSend();
        $send->telegramNewBooking($data_modif);
        return $this->data;
    }
}
