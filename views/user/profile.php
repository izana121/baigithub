<style>
.profile-wrapper {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin-right: 20px;
}

.profile-info h2 {
    margin: 0;
}

.profile-table {
    width: 100%;
    margin-top: 20px;
}

.profile-table td {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.profile-actions {
    margin-top: 30px;
}

.profile-actions a {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    margin-right: 10px;
    font-weight: 500;
}

.btn-primary {
    background: #2563eb;
    color: #fff;
}

.btn-warning {
    background: #f59e0b;
    color: #fff;
}
</style>

<div class="profile-wrapper">
    <div class="profile-header">
        <div class="profile-avatar">
            <?= strtoupper(substr($user['username'], 0, 1)) ?>
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <p><?= ucfirst($user['role']) ?></p>
        </div>
    </div>

    <table class="profile-table">
        <tr>
            <td><b>Email</b></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
        <tr>
            <td><b>Số điện thoại</b></td>
            <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
        </tr>
        <tr>
            <td><b>Vai trò</b></td>
            <td><?= $user['role'] ?></td>
        </tr>
    </table>

    <div class="profile-actions">
        <a href="index.php?page=profile_edit" class="btn-primary">Cập nhật thông tin</a>
        <a href="index.php?page=profile_password" class="btn-warning">Đổi mật khẩu</a>
    </div>
</div>
