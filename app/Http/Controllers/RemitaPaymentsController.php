<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class RemitaPaymentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $payments = Payment::query()->latest()->simplePaginate();
        return view('dashboard', compact('payments'));
    }
}
