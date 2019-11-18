<?php

namespace Bromo\Transaction\Services;

use Bromo\Transaction\Models\Order;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ShipperShippingApiService
{
    const EXPIRE_IN = 60;
 
    /**
     * @var Repository
     */
    private $auth_key;

    /**
     * @var Repository
     */
    private $base_url;
 
    /**
     * @var Client
     */
    private $httpClient;

    private const DEFAULT_TZ = 'Asia/Jakarta';

    private const UPDATE_WEIGHT = '/order/ORDER_ID';    

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->base_url = config('shippingv2.base_url');
        $this->auth_key = config('shippingv2.auth_key');
    }

    private function getBaseUrl()
    {
        return $this->base_url;
    }


    private function getTimezone()
    {
        if (is_null(session()->get('timezone'))) {
            return self::DEFAULT_TZ;
        }
        return session()->get('timezone');
    }

    public function setTimezone($tz)
    {
        $this->timezone = $tz;
        return $this;
    }

    public function setBaseUrl ( $base_url ) {
        $this->base_url = $base_url;
    }

    public function setAuthKey ( $auth_key ) {
        $this->auth_key = $auth_key;
    }

    public function updateOrder( $order_id, $new_weight ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        $size = $this->getSizeBasedOnWeight ($new_weight);
        $volume = $this->getVolumeBasedOnSize($size);

        $body = [
            'l' => $volume["l"],
            'w' => $volume["w"],
            'h' => $volume["h"],
            'wt' => $new_weight,
        ];

        try {
            $response = $this->httpClient->request('PUT', $this->getBaseUrl() . str_replace('ORDER_ID', $order_id, self::UPDATE_WEIGHT) , 
            [
                'json' => $body,
                'headers' => $headers,
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = $response->getBody()->getContents();
                
                // Getting order ID
                if(isset($content_json) && isset($content_json->error)){
                    throw new Exception($content_json->message);
                }

                if(isset($content_json) && isset($content_json->status)) {
                    if ($content_json->status != 'success') {
                        throw new Exception($content_json->data->content);
                    }
                }
                return $content;
            }
        } catch (RequestException $exception) {
            Log::error('Exception Get Message : ' . $exception->getMessage());
            // Log::error('Response: ' . isset($exception->getResponse()->getBody()->getContents()));
            // TODO use isset to get json response

            if ($exception->getCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw new Exception('Internal Server Error');
                Log::error($exception->getMessage());
            }

            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                throw new Exception('Bad Request, Something wen\'t wrong');
                Log::error($exception->getMessage());
            }

            if ($exception->getCode() == Response::HTTP_UNAUTHORIZED) {
                throw new Exception('Bad Request, Unauthorized');
                Log::error($exception->getMessage());
            }

            if ($exception->getCode() == Response::HTTP_FORBIDDEN) {
                throw new Exception('Bad Request, Forbidden');
                Log::error($exception->getMessage());
            }
        }
    }

    private function getSizeBasedOnWeight ( $weight_in_kg ) {
        if ( $weight_in_kg <= 3) return "S";
        if ( $weight_in_kg <= 8) return "M";
        return "L";
    }

    private function getVolumeBasedOnSize ( $size ) {
        switch( $size ) {
            case "S":
               return [
                  "l" => 20,
                  "w" => 20,
                  "h" => 10,
               ];
            case "M":
               return [
                  "l" => 40,
                  "w" => 40,
                  "h" => 10,
               ];
            case "L":
               return [
                  "l" => 40,
                  "w" => 40,
                  "h" => 20,
               ];      
        }
    }


}
