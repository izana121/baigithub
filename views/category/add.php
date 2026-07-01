<div class="container mt-4">
    <h3>Thêm danh mục mới</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=category_add">
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="index.php?page=admin_categories" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
