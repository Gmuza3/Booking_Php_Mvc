<?php

namespace App\helpers\authMiddleware;

use App\helpers\JWT;

class AuthMiddleware
{
    public static function check(string $uri, array $authFreeRoutes)
    {
        if (in_array($uri, $authFreeRoutes)) return;
        $jwt = new JWT();
        $verify = $jwt->verifyToken($_COOKIE['accessToken'] ?? '');

        if ($verify === null) {
            $refreshToken = $_COOKIE['refreshToken'] ?? '';
            if ($refreshToken) {
                $newAccessToken = $jwt->refreshToken($refreshToken);
                if ($newAccessToken) {
                    setcookie('accessToken', $newAccessToken, [
                        'expires' => time() + 3600,
                        'httponly' => true,
                        'secure' => false,
                        'samesite' => 'Lax'
                    ]);
                    $uri .= (strpos($uri, '?') === false ? '?' : '&') . 'refreshed=true';
                    header("Location: $uri");
                    exit;
                }
            }
            session_start();
            setcookie('accessToken', '', time() - 3600, '/');
            setcookie('refreshToken', '', time() - 3600, '/');

            unset($_SESSION['user']);
        }
    }
}
