<?php

namespace App\Jobs;

use App\Mail\PaymentConfirm;
use Illuminate\Bus\Queueable;
use App\Models\Send as ModelsSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class JobPaymentConfirm implements ShouldQueue
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
        $send = new ModelsSend();
        $mailer = $send->mailer('paymentconfirm', $this->data);
        if ($mailer['success'] == true) {
            $mail = 'SENDED';
        } else {
            $mail = 'NOT SENDED';
        }
        $data_modif = $this->data;

        $data_modif['title'] = 'BOOKING - Konfirmasi Pembayaran diterima';
        $data_modif['mail_status'] = $mail;
        $send->telegramPaymentConfirm($data_modif);
    }
}
