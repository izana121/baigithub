<div class="container mt-4">
    <h3>Sửa đối tác</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=partner_edit&id=<?php echo $partner['id']; ?>">
        <div class="form-group">
            <label for="name">Tên đối tác</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($partner['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($partner['description'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php?page=admin_partners" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
