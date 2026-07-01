<div class="container mt-4">
    <h3>Thêm đối tác mới</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=partner_add">
        <div class="form-group">
            <label for="name">Tên đối tác</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="index.php?page=admin_partners" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
