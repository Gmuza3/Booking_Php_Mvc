<?php

namespace App\model\database;

use App\model\Validation\Validation;
use Dotenv\Dotenv;

use PDO;
use PDOException;

class Database
{
  public $pdo = null;
  public static $db = null;
  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    $db_host = $_ENV['MYSQL_HOST'];
    $db_port = $_ENV['PORT'];
    $db_name = $_ENV['DB_NAME'];
    $db_user = $_ENV['DB_USER'];
    $db_pass = $_ENV['DB_PASS'];
    try {
      $this->pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$db = $this;
    } catch (PDOException $e) {
      die('DB connection failed ' . $e->getMessage());
    }
  }

  public function getDescriptions()
  {
    $stmt = $this->pdo->prepare('SELECT * FROM services');
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function createUser(Validation $validation)
  {
    $stmt = $this->pdo->prepare('INSERT INTO users(name,email,password,created_at)
            VALUE(:name,:email,:password,now())');
    $stmt->bindValue(':name', $validation->name);
    $stmt->bindValue(':email', $validation->email);
    $hash = password_hash($validation->password, PASSWORD_DEFAULT);
    $stmt->bindValue(':password', $hash);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function loginUser(Validation $validation)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindValue(':email', $validation->email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($validation->password, $user['password'])) {
      return $user;
    } else {
      return null;
    }
  }

  public function getServicesById(int $id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM services WHERE id like :id');
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function getUser(int $id)
  {
    $stmt = $this->pdo->prepare('Select * from users where id = :id');
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function updateStatusFromAdmin(string $newStatus, int $id)
  {
    $stmt = $this->pdo->prepare('update bookings set status = :newStatus where id = :id');
    $stmt->bindValue(':newStatus', $newStatus);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
  }
}
