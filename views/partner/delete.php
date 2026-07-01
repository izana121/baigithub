<div class="container mt-4">
    <h3>Xóa Đối tác</h3>
    
    <?php if ($partner): ?>
        <p>Bạn có chắc muốn xóa đối tác: <strong><?php echo htmlspecialchars($partner['name']); ?></strong> ?</p>

        <form method="POST">
            <input type="hidden" name="confirm" value="1">
            <button class="btn btn-danger">Xóa</button>
            <a href="index.php?page=admin_partners" class="btn btn-secondary">Hủy</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Đối tác không tồn tại.</div>
        <a href="index.php?page=admin_partners" class="btn btn-secondary">Quay lại</a>
    <?php endif; ?>
</div>

