<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\NewBooking as JobsNewBooking;

class SendController extends Controller
{
    public function newBooking(Request $request)
    {
        $data = $request->all();
        JobsNewBooking::dispatch($data);
    }
}
