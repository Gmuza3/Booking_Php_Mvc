<div>
    <a href="/booking">Back Home Page</a>
</div>
<div class="profile-container" style="min-width: 300px;">
    <h2>User Profile</h2>
    <form method="POST" action="/booking/profile/update">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="profile-field">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?= htmlentities($user['name']) ?>" required>
        </div>

        <div class="profile-field">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?= htmlentities($user['email']) ?>" required>
        </div>

        <div class="profile-field">
            <label for="role">Role</label>
            <input type="hidden" name='role' value="<?= htmlentities($user['role'])?>" />
            <input type="text" name="role" value="<?= htmlentities($user['role'])?>" disabled>
        </div>

        <div class="profile-field">
            <label for="created_at">Registered At</label>
            <input type="text" name="created_at" value="<?= htmlentities($user['created_at']) ?>" disabled>
        </div>

        <div class="profile-buttons">
            <button type="submit">Edit Profile</button>
        </div>
    </form>
</div>
