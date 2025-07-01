<?php
session_start();
$user = $_SESSION['user'];
?>
<div>
    <a href="/booking">Back Home Page</a>
</div>
<div class="dashbord my-3 w-100 d-flex flex-column gap-2">
    <h2 class="mb-4 text-center">📋 <?= ucfirst(htmlentities($role)) . " " . ucfirst(htmlentities($user)) ?> Booking Management Dashboard</h2>

    <?php if (empty($bookings)): ?>
        <div class="alert alert-warning text-center">There Are No Booking Yet.</div>
    <?php else: ?>
        <div class="table-responsive w-100">
            <table class="table table-bordered table-striped align-middle text-center w-100">
                <thead class="table-dark w-100">
                    <tr>
                        <th>#</th>
                        <th>👤 User</th>
                        <th>📅 Date</th>
                        <th>⏰ Time</th>
                        <th>📌 Status</th>
                        <th>🛠 Service</th>
                        <th>🖼 Picture</th>
                        <th>📄 Description</th>
                        <th>💰 Price</th>
                        <th>⏳ Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $index => $booking): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($booking['user_name']) ?></td>
                            <td class="data"><?= htmlspecialchars($booking['booking_date']) ?></td>
                            <td><?= htmlspecialchars($booking['booking_time']) ?></td>
                            <?php if (!empty($_COOKIE['role'])): ?>
                                <td>
                                    <span class="badge bg-<?= $booking['status'] === 'confirmed' ? 'success' : ($booking['status'] === 'pending' ? 'warning text-dark' : 'secondary') ?>">
                                        <form action="/booking/admin" method="POST">
                                            <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">
                                            <select name="status" id="status">
                                                <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                <option value="canceled" <?= $booking['status'] === 'canceled' ? 'selected' : '' ?>>Canceled</option>
                                            </select>
                                            <button type="submit">Change</button>
                                        </form>
                                    </span>
                                </td>
                            <?php else: ?>
                                <td>
                                    <span class="badge bg-<?= $booking['status'] === 'confirmed' ? 'success' : ($booking['status'] === 'pending' ? 'warning text-dark' : 'secondary') ?>">
                                        <?= htmlspecialchars($booking['status']) ?>
                                    </span>
                                </td>
                            <?php endif ?>
                            <td><?= htmlspecialchars($booking['service_name']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($booking['img']) ?>" alt="service image" width="80" class="rounded shadow">
                            </td>
                            <td class="description"><?= htmlspecialchars($booking['description']) ?></td>
                            <td class="price"><strong><?= htmlspecialchars($booking['price']) ?> ₾</strong></td>
                            <td><?= htmlspecialchars($booking['duration']) ?> წთ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>