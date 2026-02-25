<?php

namespace App\Service\Semaphore;

use Illuminate\Support\Facades\Http;


class SemaphoreService
{
    protected $apiKey;
    protected $baseUrl;


    public function __construct()
    {
        $this->apiKey = config('services.semaphore.api_key', env('SEMAPHORE_API_KEY'));
        $this->baseUrl = config('services.semaphore.base_url', env('SEMAPHORE_BASE_URL'));
    }

    public function sendSms(string $recipient, string $message)
    {
        $response = Http::post($this->baseUrl, [
            'apikey' => $this->apiKey,
            'number' => $recipient,
            'message' => $message,
            'sendername' => 'INFOTIPTIP', // optional: replace with your approved sender name
        ]);

        return $response->json();
    }
}
