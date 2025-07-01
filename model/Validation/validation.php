<?php

namespace App\model\Validation;

use App\helpers\JWT as HelpersJWT;
use App\model\database\Database;

class Validation
{
    public string $name;
    public string $email;
    public string $password;
    protected $token = null;

    public function load($data)
    {
        $this->name = trim($data['name'] ?? '');
        $this->email = trim($data['email'] ?? '');
        $this->password = trim($data['password'] ?? '');
    }

    public function save(string $meant)
    {
        $db = Database::$db;
        $jwt = new HelpersJWT();
        session_start();
        if ($meant === 'login') {
            $user = $db->loginUser($this);
            $_SESSION['user'] = $user['name'];
            if(isset($user) && $user['role'] === 'admin'){
                setcookie('role',$user['role'],[
                    'expires'=>time() +3600,
                    'httponly'=>true,
                    'samesite'=>'strict',
                    'secure' =>false
                ]);
            }else{
                setcookie('role','',[
                    'expires' => time() -3600
                ]);
            }
            if (!empty($user)) {
                $jwt->setData([
                    'id' => $user['id'], 
                    'email' => $user['email']
                ]);
                $this->token = $jwt->generateToken();
                setcookie('accessToken', $this->token['accessToken'], [
                    'expires' => time() + 3600,
                    'httponly' => true,
                    'samesite' => 'strict',
                    'secure' => false
                ]);
                setcookie('refreshToken', $this->token['refreshToken'], [
                    'expires' => time() + 60 * 60 * 24 * 7,
                    'httponly' => true,
                    'samesite' => 'strict',
                    'secure' => false
                ]);
                return ['status' => 'success', 'statuscode' => 200];
            } else {
                return ['status' => 'error', 'message' => 'Login Failed'];
            }
        } else if($meant === 'register') {
            $db->createUser($this);
            return ['status' => 'success', 'statuscode' => 201];
        }
    }
}
