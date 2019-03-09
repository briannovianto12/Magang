<?php

namespace Nbs\BaseResource\Services;

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Exception\IssuedInTheFuture;
use Kreait\Firebase\Exception\Messaging\AuthenticationError;
use Kreait\Firebase\Exception\Messaging\InvalidArgument;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService
{
    protected $firebase;
    private $payloadData;
    private $tokens;

    /**
     * FirebaseService constructor.
     */
    public function __construct()
    {
        if (app()->environment() == 'production') {
            $pathJsonFile = base_path('keys/') . config('fcm.firebase-sdk-prod');
        } else {
            $pathJsonFile = base_path('keys/') . config('fcm.firebase-sdk-dev');
        }
        $serviceAccount = ServiceAccount::fromJsonFile($pathJsonFile);
        $this->firebase = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
    }

    /**
     *
     * Send Fcm by Topic
     *
     * @param $topic
     * @param $data
     */
    public function sendToTopic($topic, $data)
    {
        $data['sound'] = 'default';
        $message = [
            'topic' => $topic,
            'data' => $data,
            'apns' => [
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'alert' => $data,
                        'badge' => 1,
                        'mutable-content' => 1,
                        'sound' => 'default'
                    ],
                ],
            ]
        ];

        try {
            $this->firebase->getMessaging()->send($message);
        } catch (IssuedInTheFuture $e) {

        } catch (InvalidToken $e) {

        } catch (NotFound $e) {

        } catch (InvalidArgument $e) {

        } catch (AuthenticationError $e) {

        }
    }

    public function sendToDevice()
    {
        foreach ($this->tokens as $token) {
            try {
                $data['sound'] = 'default';
                $message = [
                    'token' => $token,
                    'data' => $this->payloadData,
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'alert' => $data,
                                'badge' => 1,
                                'mutable-content' => 1,
                                'sound' => 'default'
                            ],
                        ],
                    ]
                ];

                return $this->firebase->getMessaging()->send($message);

            } catch (IssuedInTheFuture $e) {

            } catch (InvalidToken $e) {

            } catch (NotFound $e) {

            } catch (InvalidArgument $e) {

            } catch (AuthenticationError $e) {

            }
        }
    }

    public function setTokens(...$tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function createDataPayload($data): self
    {
        $this->payloadData = $data;

        return $this;
    }
}