<?php

namespace App\Services;

use GuzzleHttp\Client;
use Upstox\Client\Configuration;

class UpstoxService
{
    protected Configuration $config;

    public function __construct()
    {
        $this->config = Configuration::getDefaultConfiguration(
            sandbox: config('services.upstox.sandbox')
        )->setAccessToken(
            config('services.upstox.access_token')
        );
    }

    public function config(): Configuration
    {
        return $this->config;
    }

    public function client(): Client
    {
        return new Client();
    }
}