<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use App\Models\UpagosDirect;

class UPagosDirectService extends Controller
{
    protected $httpClient;

    private $url = 'https://www.upagosdirect.com/api/';

    private $demo_mode = false;

    public function __construct()
    {
        $uPagosDirect = UpagosDirect::first();
        $this->demo_mode = $uPagosDirect->mode;

        $token = !empty($uPagosDirect->token) ? $uPagosDirect->token : 'qnZzK9PXG6XDjXouF9u14xveuBeuukHR8bcQwHCp';

        $this->httpClient = new Client([
            'base_uri' => $this->url,
            'timeout' => 30,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
    }

    public function getData($endpoint)
    {
        try {
            $response = $this->httpClient->get($endpoint);
            $data = json_decode($response->getBody()->getContents());
            return $data;
        } catch (GuzzleException $e) {
            Log::error('Error calling µPagosDirect: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Error calling µPagosDirect'], 500);
            }
            return redirect()->back();
        }
    }

    public function postData($endpoint, $data)
    {
        try {
            $response = $this->httpClient->post($endpoint, [
                'json' => $data,
            ]);
            $data = json_decode($response->getBody()->getContents());
            return $data;
        } catch (GuzzleException $e) {
            Log::error('Error calling µPagosDirect: ' . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Error calling µPagosDirect'], 500);
            }
            return redirect()->back();
        }
    }

    public function getEfsToken()
    {
        $data = [
            'demo_mode' => $this->demo_mode,
        ];

        return $this->postData('efstoken', $data);
    }
}
