<div class="auth-box">
    <h2>Đăng nhập</h2>
    <?php if ($error) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success) : ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form action="index.php?page=login" method="POST">
        <label for="username">Tên đăng nhập hoặc Email:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Đăng nhập</button>
    </form>
    <p>Bạn chưa có tài khoản? <a href="index.php?page=register">Đăng ký ngay</a></p>
</div>
