<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

class ZerodhaService
{
    protected string $baseUrl = 'https://api.kite.trade';

    public function __construct(
        protected string $apiKey,
        protected string $accessToken,
    ) {}

    protected function client()
    {
        return Http::withHeaders([
            'X-Kite-Version' => '3',
            'Authorization' => "token {$this->apiKey}:{$this->accessToken}",
        ]);
    }

    public function holdings(): array
    {
        $kite = $this->client();
        $hld_rsp = $kite->get("{$this->baseUrl}/portfolio/holdings");
        $hld_rsp_json = $hld_rsp->json();
        return $hld_rsp_json;
    }

    public function positions(): array
    {
        $kite = $this->client();
        $pos_rsp = $kite->get("{$this->baseUrl}/portfolio/positions");
        $pos_rsp_json = $pos_rsp->json();
        return $pos_rsp_json;
    }
}