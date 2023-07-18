<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TransactionIdentifier
{
    public function generate(?string $prefix = null) : string
    {
        $identifier = ( ! $prefix ) ? str()->random(23) : str(str()->random(23))->prepend($prefix . '-')->value();

        if ( ! $this->is_unique($identifier) ) {
            $identifier = $this->generate();
        }

        return $identifier;
    }

    public function is_unique(string $identifier) : bool
    {
        return (null === DB::table('payments')->whereTransactionId($identifier)->first());

    }
}
