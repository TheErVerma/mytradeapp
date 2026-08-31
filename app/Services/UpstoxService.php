<?php

namespace App\Services;

use App\Models\BrokerIntegration;
use Auth;
use GuzzleHttp\Client;
use Log;
use Upstox\Client\Configuration;
use Illuminate\Support\Facades\Http;

class UpstoxService
{
    protected string $baseUrl = 'https://api.upstox.com/v2';
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

    public function getAccessToken(string $code): array
    {

        $response = Http::asForm()->post(
            'https://api.upstox.com/v2/login/authorization/token',
            [
                'code' => $code,
                'client_id' => config('services.upstox.client_id'),
                'client_secret' => config('services.upstox.client_secret'),
                'redirect_uri' => config('services.upstox.redirect_uri'),
                'grant_type' => 'authorization_code',
            ]
        );

        if ($response->failed()) {
            throw new \Exception(
                'Upstox token request failed: ' . $response->body()
            );
        }

        return $response->json();
    }

    public function getPortfolio()
    {
        $user_id = Auth::id();
        if ($user_id) {
            $broker_init = BrokerIntegration::where('user_id', $user_id)->first();
            $broker_init = collect($broker_init)->toArray();

            // Log::debug(print_r($broker_init, true));
            $accessToken =
                $headers = [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $broker_init['access_token'],
                ];

            $holdings = Http::withHeaders($headers)
                ->get($this->baseUrl . '/portfolio/long-term-holdings');

            $positions = Http::withHeaders($headers)
                ->get($this->baseUrl . '/portfolio/short-term-positions');

            return [
                'holdings' => $holdings->successful()
                    ? $holdings->json('data', [])
                    : [],

                'positions' => $positions->successful()
                    ? $positions->json('data', [])
                    : [],

                'holdings_response' => $holdings->json(),

                'positions_response' => $positions->json(),
            ];
        }
    }
}