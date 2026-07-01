<div class="container mt-4">
    <h2>Xóa Nhân viên</h2>
    
    <?php if ($user): ?>
    <div class="card mt-3">
        <div class="card-body">
            <h5>Thông tin nhân viên</h5>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? ''); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            
            <p class="text-danger">Bạn có chắc chắn muốn xóa nhân viên: <strong><?php echo htmlspecialchars($user['username']); ?></strong> ?</p>
            
            <form method="POST" class="d-inline">
                <input type="hidden" name="confirm" value="1">
                <button type="submit" class="btn btn-danger">Xóa</button>
                <a href="index.php?page=admin_staff" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">Không tìm thấy người dùng.</div>
    <?php endif; ?>
</div>
