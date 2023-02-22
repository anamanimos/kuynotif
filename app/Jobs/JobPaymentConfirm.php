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
        if (Mail::to($this->request['customer']['email'])->send(new PaymentConfirm($this->data))) {
            $mail = 'SENDED';
        } else {
            $mail = 'NOT SENDED';
        }
        $data_modif = $this->data;

        $data_modif['title'] = 'BOOKING - Konfirmasi Pembayaran diterima';
        $data_modif['mail_status'] = $mail;
        $send = new ModelsSend();
        $send->telegramPaymentConfirm($data_modif);
    }
}
