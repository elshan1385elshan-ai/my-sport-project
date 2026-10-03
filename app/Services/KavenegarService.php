<?php

namespace App\Services;

use Kavenegar\KavenegarApi;

class KavenegarService
{
    public function sendOtp(string $phone, string $code)
    {
        $api = new KavenegarApi(
            config('kavenegar.api_key')
        );

        return $api->VerifyLookup(
            $phone,
            $code,
            null,
            null,
            'verify',
            'sms'
        );
    }
}