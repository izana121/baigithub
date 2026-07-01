<div class="container mt-4">
    <h2>Xóa Sản Phẩm</h2>
    
    <?php if ($product): ?>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                </div>
                <div class="col-md-9">
                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                    <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?>đ</p>
                    <p class="text-danger">Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                    
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                        <a href="index.php?page=product&id=<?php echo $product['id']; ?>" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">Không tìm thấy sản phẩm.</div>
    <?php endif; ?>
</div>
