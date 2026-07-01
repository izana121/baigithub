<style>
.profile-wrapper {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-weight: 500;
    display: block;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.btn-warning {
    background: #f59e0b;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
</style>

<div class="profile-wrapper">
    <h2>Đổi mật khẩu</h2>

    <?php if ($success): ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Mật khẩu cũ</label>
            <input type="password" name="current_password" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu mới (ít nhất 8 ký tự)</label>
            <input type="password" name="new_password" minlength="8" required>
        </div>

        <div class="form-group">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button class="btn-warning">Đổi mật khẩu</button>
        <a href="index.php?page=profile" style="margin-left:10px;">Quay lại</a>
    </form>
</div>
