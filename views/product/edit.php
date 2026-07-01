<div class="container mt-5">
    <h2>Sửa Sản Phẩm</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($product): ?>
        <form action="index.php?page=product_sua&id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" class="form-control" id="price" name="price" step="1"
                    value="<?php echo (int) $product['price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock">Số lượng tồn:</label>
                <input type="number" class="form-control" id="stock" name="stock"
                    value="<?php echo (int) $product['stock']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Ảnh sản phẩm:</label>
                <?php if (!empty($product['image'])): ?>
                    <div class="mb-2">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" style="max-width:150px;">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                <small class="text-muted">Để trống nếu không thay đổi ảnh</small>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="manufacturer_id">Nhà sản xuất:</label>
                <select class="form-control" id="manufacturer_id" name="manufacturer_id" required>
                    <option value="">-- Chọn nhà sản xuất --</option>
                    <?php foreach ($partners as $nsx): ?>
                        <option value="<?php echo $nsx['id']; ?>" <?php echo $nsx['id'] == $product['manufacturer_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nsx['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="index.php?page=product&id=<?php echo $product['id']; ?>" class="btn btn-secondary">Quay lại</a>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">Không tìm thấy sản phẩm.</div>
    <?php endif; ?>
</div>
