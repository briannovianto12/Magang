<?php

namespace Bromo\Tools\Services;

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

    private const RATES_FOR_SHIPPER = '/rates?o=ORIG_LOC_ID&d=DEST_LOC_ID&l=LENGTH&w=WIDTH&h=HEIGHT&wt=WEIGHT&v=AMT';

    // TODO call GO API with this url
    // private const RATES_WITH_LOGISTIC = '/shipping/rates?ver=2&dest_loc_id=DEST_LOC_ID&
    // dimension_height=HEIGHT&dimension_length=LENGTH&orig_loc_id=ORIG_LOC_ID&
    // value_amount=AMT&weight=WEIGHT&dimension_width=WIDTH&shop_id=SHOP_ID';

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

    public function simulateShipping( $data ) {

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Auth-Key' => $this->auth_key,
        ];

        $volume = $this->getVolumeBasedOnSize($data['package-size']);
        $body = [
            'l' => $volume["l"],
            'w' => $volume["w"],
            'h' => $volume["h"],
            'wt' => $data["package-weight"],
        ];
        try {
            $response = $this->httpClient->request('GET', $this->getBaseUrl() . $this->setParameters($data, $volume) , 
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

    private function setParameters($data, $volume){

        $url = self::RATES_FOR_SHIPPER;
        $url = str_replace('ORIG_LOC_ID', $data["origin-subdistrict"], $url);
        $url = str_replace('DEST_LOC_ID', $data["destination-subdistrict"], $url);
        $url = str_replace('LENGTH', $volume["l"], $url);
        $url = str_replace('WIDTH', $volume["w"], $url);
        $url = str_replace('HEIGHT', $volume["h"], $url);
        $url = str_replace('WEIGHT', $data["package-weight"], $url);
        $url = str_replace('AMT', $data["package-value"], $url);

        return $url;
    }
}