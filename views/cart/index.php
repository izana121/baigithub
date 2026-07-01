<div class="container cart-page">
    <h2>Giỏ hàng của bạn</h2>

    <?php if (empty($items)): ?>
        <p>Giỏ hàng trống.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td>
                            <img src="images/<?php echo htmlspecialchars($it['image']); ?>" alt="" style="width:60px;height:60px;object-fit:cover;margin-right:8px;">
                            <?php echo htmlspecialchars($it['name']); ?>
                        </td>
                        <td><?php echo number_format($it['price'],0); ?>đ</td>
                        <td>
                            <form method="post" action="index.php?page=cart_update" style="display:inline-block;">
                                <input type="hidden" name="cart_item_id" value="<?php echo intval($it['cart_item_id']); ?>">
                                <input type="number" name="quantity" value="<?php echo intval($it['quantity']); ?>" min="0" style="width:80px;display:inline-block;" />
                                <button class="btn btn-sm btn-primary" type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($it['subtotal'],0); ?>đ</td>
                        <td>
                            <form method="post" action="index.php?page=cart_remove">
                                <input type="hidden" name="cart_item_id" value="<?php echo intval($it['cart_item_id']); ?>">
                                <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <strong>Tổng: <?php echo number_format($total,0); ?>đ</strong>
        </div>

        <div style="margin-top:12px;">
            <a href="index.php?page=category&id=1" class="btn btn-secondary">Tiếp tục mua sắm</a>
            <a href="index.php?page=payment" class="btn btn-success ml-2">Thanh toán</a>
        </div>
    <?php endif; ?>
</div>
