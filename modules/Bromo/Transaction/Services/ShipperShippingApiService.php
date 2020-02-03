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

    private const CREATE_ORDER = '/order/create';
    private const ACTIVATION_ORDER = '/order/activate?order_id=ORDER_ID';
    private const CANCEL_ORDER = '/order/ORDER_ID/cancel';
    private const GET_TRACKING_ID = '/order?id=ORDER_ID';
    private const GET_ORDER_DETAILS = '/order/ORDER_ID';

    public const PACKAGE_TYPE_DOCUMENT = 1;
    public const PACKAGE_TYPE_SMALL = 2;
    public const PACKAGE_TYPE_MEDIUM = 3;

    public const COD_TYPE_NONE = 0;
    public const COD_TYPE_YES = 1;

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

    public function getSizeBasedOnWeight ( $weight_in_kg ) {
        if ( $weight_in_kg <= 3) return "S";
        if ( $weight_in_kg <= 8) return "M";
        return "L";
    }

    public function getVolumeBasedOnSize ( $size ) {
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

    public function createOrder( $params ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        try {
            $response = $this->httpClient->request('POST', $this->getBaseUrl() . self::CREATE_ORDER, [
                'json' => $params,
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = $response->getBody()->getContents();
                $content_json = json_decode($content);
                
                // Getting order ID
                if(isset($content_json) && isset($content_json->error)){
                    throw new Exception($content_json->message);
                }

                if(isset($content_json) && isset($content_json->status)) {
                    if ($content_json->status != 'success') {
                        throw new Exception($content_json->data->content);
                    }
                }
                return $content_json->data->id;
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

        /**
     * Activate order to pickup
     * 
     * @param order_id shipper order_id
     */
    public function activateOrder( $order_id ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        try {
         
            $response = $this->httpClient->request('PUT', $this->getBaseUrl() . str_replace('ORDER_ID', $order_id, self::ACTIVATION_ORDER), [
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = json_decode($response->getBody()->getContents());
    
                if(isset($content) && isset($content->status)) {
                    if($content->status != 'success'){
                        throw new Exception($content->data->content);
                    }
                }
                return $content;
            }
        } catch (Exception $exception) {
            Log::error('Exception Get Message : ' . $exception->getMessage());// , json_decode($exception->getResponse()->getBody()->getContents(), true));

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

    /**
     * Get Tracking ID
     * 
     * @param order_id shipper order_id
     * @return string get tracking ID
     */
    public function getTrackingID( $order_id ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        try {
         
            $response = $this->httpClient->request('GET', $this->getBaseUrl() . str_replace('ORDER_ID', $order_id, self::GET_TRACKING_ID), [
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = json_decode($response->getBody()->getContents());

                if(isset($content) && isset($content->status)) {
                    if($content->status != 'success'){
                        throw new Exception($content->data->content);
                    }
                    return $content->data->id;
                }
            }
        } catch (RequestException $exception) {
            Log::error('Exception Get Message : ' . $exception->getMessage(), json_decode($exception->getResponse()->getBody()->getContents(), true));

            if ($exception->getCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
                throw new Exception('Internal Server Error');
            }

            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                throw new Exception('Bad Request, Something wen\'t wrong');
            }

            if ($exception->getCode() == Response::HTTP_UNAUTHORIZED) {
                throw new Exception('Bad Request, Unauthorized');
            }

            if ($exception->getCode() == Response::HTTP_FORBIDDEN) {
                throw new Exception('Bad Request, Forbidden');
            }
        }
    }

    /**
     * Cancel Order
     * 
     * @param order_id shipper order_id
     * @return string message
     */
    public function cancelOrder( $order_id ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        try {
         
            $response = $this->httpClient->request('PUT', $this->getBaseUrl() . str_replace('ORDER_ID', $order_id, self::CANCEL_ORDER), [
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = json_decode($response->getBody()->getContents());
               
                if($content->status != 'success') {
                    throw new Exception($content->data->content);
                }
                return $content->data->message;
            }
        } catch (RequestException $exception) {
            Log::error('Exception Get Message : ' . $exception->getMessage());// , json_decode($exception->getResponse()->getBody()->getContents(), true));

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

}
