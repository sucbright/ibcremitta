<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gateways\RemitaGateway;
use App\Http\Requests\VerifyPaymentRequest;

class VerifyPaymentController
{
    public function __invoke(Request $request)
    {
        (new RemitaGateway())->verify($request->transactionId);
    }
}
