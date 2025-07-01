<?php

namespace App\controller;

use App\helpers\JWT;
use App\model\Validation\Validation;
use App\router\Routers;
use PDO;

interface MethodInterface
{
    public function index();
    public function login();
    public function register();
    public function logOut();
    public function service();
    public function profile();
    public function updateProfile();
    public function dashbord();
    public function newBookings();
    public function admin();
}

abstract class BaseAbstractcontroller implements MethodInterface
{
    protected Routers $router;
    public function __construct(Routers $router)
    {
        $this->router = $router;
    }
}

class authcontroller extends BaseAbstractcontroller
{
    public function index()
    {
        $descriptions = $this->router->database->getDescriptions();
        return $this->router->renderView('index', [
            'descriptions' => $descriptions
        ]);
    }

    public function login()
    {
        $user = [
            'email' => '',
            'password' => '',
        ];

        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $user['email'] = $_POST['email'] ?? '';
            $user['password'] = $_POST['password'] ?? '';

            $validation = new Validation();
            $validation->load($user);
            $result = $validation->save('login');
            if ($result['status'] === 'success' && $result['statuscode'] === 200) {
                header('Location: /booking');
                exit;
            } else if ($result['status'] === 'error') {
                echo $result['message'];
            }
        }
        $this->router->renderView('login', [
            'user' => $user,
            'result' => $result
        ]);
    }

    public function register()
    {
        $postFields = [
            'name' => '',
            'email' => '',
            'password' => '',
        ];

        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postFields['name'] = $_POST['name'] ?? '';
            $postFields['email'] = $_POST['email'] ?? '';
            $postFields['password'] = $_POST['password'] ?? '';

            $validation = new Validation();
            $validation->load($postFields);
            $result = $validation->save('register', $postFields);

            if ($result['status'] === 'success' && $result['statuscode'] === 201) {
                header('Location: /booking/login');
                exit;
            }
        }

        $this->router->renderView('register', [
            'user' => $postFields,
            'result' => $result
        ]);
    }

    public function logOut()
    {
        $accessToken = $_COOKIE['accessToken'];
        $refreshToken = $_COOKIE['refreshToken'];
        if ($accessToken || $refreshToken) {
            setcookie('accessToken', '', [
                'expires' => time() - 3600
            ]);
            setcookie('refreshToken', '', [
                'expires' => time() - 3600
            ]);
            header('Location: /booking');
            exit;
        }

    }

    public function dashbord()
    {
        $jwt = new JWT;
        $verify = $jwt->verifyToken($_COOKIE['accessToken'] ?? null);
        $id = $verify->data->id;

        $user = $this->router->database->getUser($id);

        if ($user['role'] === 'admin') {
            $stmt = $this->router->database->pdo->prepare("
        SELECT 
            a.name AS user_name,
             b.id AS booking_id,
            b.booking_date, 
            b.booking_time, 
            b.status,
            c.name AS service_name,
            c.img, 
            c.description, 
            c.price, 
            c.duration
        FROM bookings AS b
        INNER JOIN users AS a ON a.id = b.user_id
        INNER JOIN services AS c ON c.id = b.service_id
    ");
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->router->renderView('dashboard', [
                'bookings' => $bookings,
                'role' => $user['role']
            ]);
        } else {
            $stmt = $this->router->database->pdo->prepare("
        SELECT 
            a.name AS user_name,
            b.id AS booking_id,
            b.booking_date, 
            b.booking_time, 
            b.status,
            c.name AS service_name,
            c.img, 
            c.description, 
            c.price, 
            c.duration
        FROM bookings AS b
        INNER JOIN users AS a ON a.id = b.user_id
        INNER JOIN services AS c ON c.id = b.service_id
        where a.id =:id
    ");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->router->renderView('dashboard', [
                'bookings' => $bookings,
                'role' => $user['role']
            ]);
        }
    }

    public function service()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID არ გადმოეცა!";
            return;
        }
        $service = $this->router->database->getServicesById($id);
        $this->router->renderView('singleservice', [
            'service' => $service
        ]);
    }

    public function newBookings()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $userId = $data['user_id'];
            $serviceId = $data['service_id'];
            $bookingDate = $data['booking_date'];
            $bookingTime = $data['booking_time'];
            $stmt = $this->router->database->pdo->prepare("
            INSERT INTO bookings (user_id, service_id, booking_date, booking_time)
            VALUES (:user_id, :service_id, :booking_date, :booking_time)
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':service_id' => $serviceId,
                ':booking_date' => $bookingDate,
                ':booking_time' => $bookingTime,
            ]);
            header("Location: /booking");
            exit;
            echo "Booking added successfully!";
        }
        $this->router->renderView('newbooking', []);
    }

    public function profile()
    {
        $jwt = new JWT;
        $verify = $jwt->verifyToken($_COOKIE['accessToken'] ?? null);
        $userId = $verify?->data->id ?? null;

        $user = $this->router->database->getUser($userId);

        if (isset($user)) {
            $this->router->renderView('profile/profile', [
                'user' => $user
            ]);
        } else {
            $this->router->renderView('profile/profile', []);
        }
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            $stmt = $this->router->database->pdo->prepare(
                'update users 
                set name = :name, email=:email,role=:role,created_at=now()
                where id = :id'
            );
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':email' => $email,
                ':role' => $role
            ]);
            $newuser = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->router->renderView('profile/update', [
                'user' => $newuser
            ]);
            header("Location: /booking?status=success");
            exit;
        }
    }
    public function admin()
    { $newStatus = $_POST['status'] ?? null;
            $bookingId = $_POST['booking_id'] ?? null;
            echo $bookingId;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'] ?? null;
            $bookingId = $_POST['booking_id'] ?? null;

            echo $bookingId;
            if ($newStatus && $bookingId) {
                $this->router->database->updateStatusFromAdmin($newStatus, (int)$bookingId);
            }

            header('Location: /booking/dashboard');
            exit;
        }
    }
}
