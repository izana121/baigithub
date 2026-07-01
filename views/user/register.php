<div class="auth-box">
    <h2>Đăng ký</h2>
    <?php if ($error) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success) : ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form action="index.php?page=register" method="POST">
        <label for="reg_username">Tên đăng nhập:</label><br>
        <input type="text" id="reg_username" name="reg_username" pattern="[a-zA-Z0-9_]+" title="Chỉ chứa chữ cái, số và dấu gạch dưới" required><br><br>

        <label for="reg_email">Email:</label><br>
        <input type="email" id="reg_email" name="reg_email" required><br><br>

        <label for="reg_password">Mật khẩu (ít nhất 8 ký tự):</label><br>
        <input type="password" id="reg_password" name="reg_password" minlength="8" required><br><br>

        <label for="reg_confirm_password">Xác nhận mật khẩu:</label><br>
        <input type="password" id="reg_confirm_password" name="reg_confirm_password" minlength="8" required><br><br>

        <button type="submit" name="register">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập</a></p>
</div>
