<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionIdentifier;

class InitiateRemitaPaymentController
{
    public function __invoke(TransactionIdentifier $identifier)
    {

        $payment = \App\Models\Payment::create([
            'transaction_id' => $identifier->generate('IBC')
        ]);
        $transactionId = $payment->transaction_id;

        return view('pay', compact('transactionId'));

    }
}
