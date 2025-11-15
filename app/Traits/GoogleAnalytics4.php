<?php

namespace App\Traits;


use Exception;
use Illuminate\Support\Facades\Http;


trait GoogleAnalytics4
{
    private string $clientId = '';

    private bool $debugging = false;



    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function enableDebugging(): self
    {
        $this->debugging = true;

        return $this;
    }
    public function postEvent($eventData)
    {
        try {
            if (session()->get('google-analytics-4-measurement-protocol.client_id')) {
                if (!$this->clientId && !$this->clientId = session(config('google-analytics-4-measurement-protocol.client_id_session_key'))) {
                    throw new Exception('Please use the package provided blade directive or set client_id manually before posting an event.');
                }

                $response = Http::withOptions([
                    'query' => [
                        'measurement_id' => config('google-analytics-4-measurement-protocol.measurement_id'),
                        'api_secret' => config('google-analytics-4-measurement-protocol.api_secret'),
                    ],
                ])->post($this->getRequestUrl(), [
                    'client_id' => $this->clientId,
                    'events' => [$eventData],
                ]);

                if ($this->debugging) {
                    return $response->json();
                }

                return [
                    'status' => $response->successful()
                ];
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getRequestUrl(): string
    {
        $url = 'https://www.google-analytics.com';
        $url .= $this->debugging ? '/debug' : '';

        return $url.'/mp/collect';
    }
}
