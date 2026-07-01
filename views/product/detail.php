<link rel="stylesheet" href="css/review.css">

<div class="container product-detail">
    <?php if ($product): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="price"><?php echo htmlspecialchars(number_format($product['price'], 0)); ?>đ</p>
                <p>Số lượng tồn kho: <?php echo htmlspecialchars($product['stock']); ?></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <form method="post" action="index.php?page=cart_add" style="display:inline-block; margin-right:8px;">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <button class="btn btn-primary" type="submit">Cho vào giỏ hàng</button>
                </form>

                <?php if ($isAdmin): ?>
                    <a href="index.php?page=product_sua&id=<?php echo $product_id; ?>" class="btn btn-secondary ml-2">Sửa sản phẩm</a>
                    <a href="index.php?page=product_del&id=<?php echo $product_id; ?>" class="btn btn-danger ml-2">Xóa sản phẩm</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</div>

<div class="container review-section">
    <div class="row mt-4">
        <div class="col-md-12">
            <h3 class="review-title">Đánh giá sản phẩm</h3>
            <form method="post" action="index.php?page=review_add" class="review-form">
                <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($_SESSION['username'] ?? 'Ẩn danh') ?>">
                
                <div class="form-group">
                    <label for="rating">Đánh giá</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="5">&#11088;&#11088;&#11088;&#11088;&#11088;</option>
                        <option value="4">&#11088;&#11088;&#11088;&#11088;</option>
                        <option value="3">&#11088;&#11088;&#11088;</option>
                        <option value="2">&#11088;&#11088;</option>
                        <option value="1">&#11088;</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comment">Nội dung đánh giá</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Gửi đánh giá</button>
            </form>
        </div>
    </div>

    <div class="row mt-4"> 
        <div class="col-md-12">
            <h4 class="review-list-title">Danh sách đánh giá</h4> 
        <?php
        if (!empty($reviews)) {
            foreach ($reviews as $r) {
                echo "<div class='review-item mb-3 p-2 border rounded'>";
                echo "<strong>" . htmlspecialchars($r['username']) . "</strong>";
                echo " - &#11088;" . intval($r['rating']) . "<br/>";
                echo "<p>" . nl2br(htmlspecialchars($r['comment'])) . "</p>";
                echo "<small>Thời gian: " . htmlspecialchars($r['created_at']) . "</small>"; 
                if (
                    (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ||
                    (isset($_SESSION['username']) && $_SESSION['username'] === 'test')
                ) {
                    echo "<br><a href='index.php?page=review_del&id=" . $r['id'] . "&product_id=" . $product_id . "' class='btn btn-sm btn-danger mt-2' onclick='return confirm(\"Bạn có chắc chắn muốn xóa comment này không?\")'>Xoá</a>";
                } 
                echo "</div>";
            }
        } else {
            echo "<p>Chưa có đánh giá cho sản phẩm này.</p>";
        } 
        ?>
    </div> 
</div>
</div>
