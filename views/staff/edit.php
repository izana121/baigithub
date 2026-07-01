<div class="container mt-4">
    <h3>Sửa người dùng</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=staff_edit&id=<?php echo $staff['id']; ?>">
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($staff['username']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($staff['email'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['phone'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php?page=admin_staff" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
