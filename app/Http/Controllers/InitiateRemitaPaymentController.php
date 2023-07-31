<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TransactionIdentifier;
use Symfony\Component\HttpFoundation\Response;

class InitiateRemitaPaymentController
{
    public function __invoke(TransactionIdentifier $identifier)
    {

        $payment = \App\Models\Payment::create([
            'transaction_id' => $identifier->generate('IBC')
        ]);
        // $transactionId = $payment->transaction_id;

        return new JsonResponse([
            'transactionId' => $payment->transaction_id
        ], Response::HTTP_OK);

    }
}
