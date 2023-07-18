<?php

declare(strict_types=1);

if ( ! function_exists('httpClient')) {
    function httpClient()
    {
        return (\App::environment('production')) ? \Http::acceptJson() : \Http::withOptions(['verify' => false])->acceptJson();
    }
}
