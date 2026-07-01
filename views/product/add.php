<div class="container mt-5">
    <h2>Thêm Sản Phẩm Mới</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="index.php?page=product_add" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" class="form-control" id="price" name="price" step="1" required>
        </div>
        <div class="form-group">
            <label for="stock">Số lượng tồn:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="0">
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Ảnh sản phẩm:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $category_id ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="manufacturer_id">Nhà sản xuất:</label>
            <select class="form-control" id="manufacturer_id" name="manufacturer_id">
                <option value="">-- Chọn nhà sản xuất --</option>
                <?php foreach ($partners as $nsx): ?>
                    <option value="<?php echo $nsx['id']; ?>">
                        <?php echo htmlspecialchars($nsx['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
