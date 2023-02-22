<?php

namespace App\Http\Controllers;

use App\Jobs\JobNewBooking;
use Illuminate\Http\Request;
use App\Jobs\JobPaymentConfirm;
use App\Jobs\JobPaymentError;
use App\Jobs\JobPaymentExpired;
use App\Jobs\JobPaymentFailed;
use App\Jobs\JobPaymentRefund;
use App\Jobs\JobPaymentSuccess;

class SendController extends Controller
{
    public function newBooking(Request $request)
    {
        $data = $request->all();
        JobNewBooking::dispatch($data);
    }

    public function paymentConfirm(Request $request)
    {
        $data = $request->all();
        JobPaymentConfirm::dispatch($data);
    }

    public function paymentSuccess(Request $request)
    {
        $data = $request->all();
        JobPaymentSuccess::dispatch($data);
    }

    public function paymentError(Request $request)
    {
        $data = $request->all();
        JobPaymentError::dispatch($data);
    }

    public function paymentFailed(Request $request)
    {
        $data = $request->all();
        JobPaymentFailed::dispatch($data);
    }

    public function paymentRefund(Request $request)
    {
        $data = $request->all();
        JobPaymentRefund::dispatch($data);
    }

    public function paymentExpired(Request $request)
    {
        $data = $request->all();
        JobPaymentExpired::dispatch($data);
    }
}
