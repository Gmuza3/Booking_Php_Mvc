<?php

use App\helpers\JWT;

$jwt = new JWT;
$verify = $jwt->verifyToken($_COOKIE['accessToken'] ?? null);
$userId = $verify?->data->id ?? null;

$serviceId = $_GET['id'] ?? null;
$serviceName = $_GET['service'] ?? null;

$today = date('Y-m-d');
?>
<div>
    <a href="/booking">Back Home Page</a>
</div>
<div class="booking-form-wrapper">
  <form method="POST" class="booking-form">
    <input type="hidden" name="user_id" value="<?= $userId ?>">
    <input type="hidden" name="service_id" value="<?= $serviceId ?>">

    <div>
      <label for="readonly-input">User_Id</label>
      <input type="text" value="<?= $userId ?>" class="readonly-input" disabled>
    </div>
    <div>
      <label for="readonly-input">Service Name</label>
      <input type="text" value="<?= $serviceName ?>" class="readonly-input" disabled>
    </div>

    <h2>Book Your Service</h2>

    <label for="date">Select Date</label>
    <input type="date" name="booking_date" required min="<?= $today ?>">

    <label for="time">Select Time</label>
    <input type="time" name="booking_time" id="booking_time"
           min="10:00" max="20:00"
           required>
    <button type="submit">Book Now</button>
  </form>
</div>
