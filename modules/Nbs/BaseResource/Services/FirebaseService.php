<?php

namespace Nbs\BaseResource\Services;

use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Exception\IssuedInTheFuture;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\AuthenticationError;
use Kreait\Firebase\Exception\Messaging\InvalidArgument;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\AndroidConfig;
use Nbs\BaseResource\Exceptions\FirebaseKeyNotFoundException;

class FirebaseService
{
    protected $firebase;
    /**
     * @var Application
     */
    protected $app;
    /**
     * @var Repository|mixed config
     */
    protected $config;
    /**
     * @var array
     */
    protected $tokens;
    protected $userId;
    protected $androidPayloadData;
    protected $iosPayloadData;
    protected $code;

    /**
     * FirebaseService constructor.
     * @param $app
     * @param $config
     */
    public function __construct($app, $config)
    {
        $this->app = $app ?? app();

        $this->config = $config ?? config();

        $this->createServiceAccount();
    }

    private function createServiceAccount()
    {
        $this->firebase = (new Factory())
            ->withServiceAccount(ServiceAccount::fromJsonFile($this->getPathJsonFile()))
            ->create();
    }

    private function getPathJsonFile()
    {
        $prod = base_path('keys/') . $this->config['firebase-sdk-prod'];
        $dev = base_path('keys/') . $this->config['firebase-sdk-dev'];

        if (!file_exists($prod)) {
            throw new FirebaseKeyNotFoundException('Firebase key production not found');
        }
        if (!file_exists($dev)) {
            throw new FirebaseKeyNotFoundException('Firebase key development not found');
        }

        return $this->app->environment('production') ? $prod : $dev;
    }

    private function formatApns(): array
    {
        return [
            'headers' => [
                'apns-priority' => '10',
            ],
            'payload' => [
                'aps' => [
                    'alert' => [
                        'user_id' => (string)$this->userId,
                        'code' => (string)$this->code,
                        'data' => collect($this->iosPayloadData)->toJson()
                    ],
                    'badge' => 1,
                    'mutable-content' => 1,
                    'sound' => 'default'
                ],
            ]
        ];
    }

    private function formatAndroid(): array
    {
        return [
            'ttl' => '3600s',
            'priority' => 'normal',
            'data' => [
                'user_id' => (string)$this->userId,
                'code' => (string)$this->code,
                'data' => collect($this->androidPayloadData)->toJson()
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getFirebase()
    {
        return $this->firebase;
    }

    public function setTokens($tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function toAndroid(string $userId, string $code, array $data): self
    {
        $this->userId = $userId;
        $this->androidPayloadData = $data;
        $this->code = $code;

        return $this;
    }

    public function sendToDevice(): void
    {
        foreach ($this->tokens as $token) {
            if (is_null($token) || $token == '') {
                continue;
            }

            try {
                $message['token'] = $token;

                if ($this->iosPayloadData) {
                    $message['apns'] = $this->formatApns();
                }

                if ($this->androidPayloadData) {
                    $message['android'] = $this->formatAndroid();
                }

                $this->getFirebase()
                    ->getMessaging()
                    ->send($message);

            } catch (IssuedInTheFuture $e) {
                Log::warning('Error Fcm : ', [$e->getToken()]);
            } catch (InvalidToken $e) {
                Log::warning('Invalid Token : ', [$e->getToken()]);
            } catch (NotFound $e) {
                Log::warning('Token not found');
            } catch (InvalidArgument $e) {
                Log::warning('Firebase Invalid Argument');
            } catch (AuthenticationError $e) {
                Log::warning('Firebase Auth Error');
            }
        }
    }

    /**
     *
     * Send Fcm by Topic
     *
     * @param $topic
     * @param $data
     */
    public function sendToTopic(string $topic, array $data)
    {
        $data['sound'] = 'default';
        $message = CloudMessage::fromArray([
            'topic' => $topic,
            'notification' =>  $data
        ]);

        $config = AndroidConfig::fromArray([
            'ttl' => '3600s',
            'priority' => 'normal'
        ]);

        try {
            $this->firebase->getMessaging()->send($message->withAndroidConfig($config));
            Log::info('Send notification', [$message]);
        } catch (IssuedInTheFuture $e) {
            Log::error('FCM : ', [$e->getToken()]);
        } catch (InvalidToken $e) {
            Log::error('FCM: Invalid Token : ', [$e->getToken()]);
        } catch (NotFound $e) {
            Log::error('FCM: Token not found');
        } catch (InvalidArgument $e) {
            Log::error('FCM: Firebase Invalid Argument');
        } catch (AuthenticationError $e) {
            Log::error('FCM: Firebase Auth Error');
        }
    }
}
