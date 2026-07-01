<link rel="stylesheet" href="css/partners.css">

<div class="container">
    <div class="back-button">
        <a href="index.php?page=admin_partners" class="btn btn-secondary">
            ← Quay lại danh sách
        </a>
    </div>

    <?php if ($partner): ?>
    <div class="detail-box">
        <div class="detail-header">
            <h2>Sản phẩm của <?= htmlspecialchars($partner['name']) ?></h2>
            <span><?= count($products) ?> sản phẩm</span>
        </div>

        <div class="detail-body">
            <?php if ($products): ?>
                <?php foreach ($products as $p):
                    $total = $p['price'] * $p['stock'];
                ?>
                    <div class="product-item">
                        <?php if ($p['image']): ?>
                            <img src="images/<?= htmlspecialchars($p['image']) ?>" class="product-image" alt="<?= htmlspecialchars($p['name']) ?>">
                        <?php else: ?>
                            <div class="product-image" style="display:flex;align-items:center;justify-content:center">No Image</div>
                        <?php endif; ?>

                        <div class="product-info">
                            <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                            <div class="product-detail-item">
                                <strong>Giá:</strong>
                                <?= number_format($p['price']) ?>đ
                            </div>
                            <div class="product-detail-item">
                                <strong>Tồn kho:</strong> <?= $p['stock'] ?>
                            </div>
                            <div class="product-detail-item">
                                <strong>Giá trị:</strong>
                                <?= number_format($total) ?>đ
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">Chưa có sản phẩm</div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">Không tìm thấy đối tác.</div>
    <?php endif; ?>
</div>
