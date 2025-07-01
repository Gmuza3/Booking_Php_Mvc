<?php

namespace App\helpers;

use Dotenv\Dotenv;
use Exception;
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT
{
    public $accesskey;
    public $refreshkey;
    protected array $data = [];

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->accesskey = $_ENV['JWT_SECRET_KEY'];
        $this->refreshkey = $_ENV['JWT_REFRESH_TOKEN'];
    }

    public function generateToken()
    {
        $accesspayload = [
            'iat' => time(),
            "exp" => time() + 3600,
            'data' => $this->data
        ];

        $refreshpayload = [
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 7,
            'data' => $this->data
        ];

        return [
            'accessToken' => FirebaseJWT::encode($accesspayload, $this->accesskey, 'HS256'),
            'refreshToken' => FirebaseJWT::encode($refreshpayload, $this->refreshkey, 'HS256'),
        ];
    }

    public function setData(array $data)
    {
        return $this->data = $data;
    }
     public function verifyToken(string $jwt)
   {
       if (empty($jwt)) return null; 
       try {
           return FirebaseJWT::decode($jwt, new Key($this->accesskey, 'HS256'));
       } catch (Exception $e) {
           return null;
       }
   }
    public function refreshToken(string $refreshToken)
    {
        try {
            $decoded = FirebaseJWT::decode($refreshToken, new key($this->refreshkey, 'HS256'));

            $this->data = (array) $decoded->data;
            $accessPayload = [
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => $this->data
            ];

            return FirebaseJWT::encode($accessPayload,$this->accesskey,'HS256');
        } catch (Exception $e) {
            return null;
        }
    }
}
