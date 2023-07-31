<?php

declare(strict_types=1);

namespace App\Services\Gateways;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RemitaGateway
{
    public function verify(string $transactionId)
    {
        $payment = $this->fetchPayment($transactionId);

        if ($payment === null) {
            throw new InvalidTransaction('Invalid Transaction - Payment could not be retrieved!');
        }

        $transactionHash = $this->makeHash($transactionId, config('ibc_remita.secret_key'));

        $response = Http::remita()
            ->withHeaders([
                'publicKey' => config('ibc_remita.public_key'),
                'TXN_HASH' => $transactionHash
            ])
            ->get('/payment/query/' . $transactionId)
            ->throw(function (Response $response, RequestException $exception): void {
                throw new InvalidTransaction($exception->getMessage());
            });

        $payload = json_decode($response->body(), false);

        $payment->update([
            'payment_reference' => $payload->responseData[0]->paymentReference,
            'amount' => $payload->responseData[0]->amount,
            'charged_amount' => $payload->responseData[0]->debitedAmount,
            'first_name' => $payload->responseData[0]->firstName,
            'last_name' => $payload->responseData[0]->lastName,
            'email' => $payload->responseData[0]->email,
            'payment_status' => $payload->responseData[0]->paymentState,
        ]);

        return new JsonResponse(['status' => 'verified'], HttpResponse::HTTP_OK);


    }

    private function makeHash(string $transactionId, string $secretKey) : string
    {
        return hash('sha512', $transactionId.$secretKey);
    }

    private function fetchPayment(string $transactionId) : Payment
    {
        return Payment::whereTransactionId($transactionId)->first();
    }
}
