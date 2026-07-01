<div class="container mt-4">
    <h3>Chi tiết Đơn hàng #<?php echo $order['id']; ?></h3>
    <p>Khách: <?php echo htmlspecialchars($order['username'] ?? 'Khách'); ?> — <?php echo htmlspecialchars($order['email'] ?? ''); ?></p>
    <p>Ngày: <?php echo htmlspecialchars($order['created_at']); ?></p>
    <p>Trạng thái hiện tại: <strong><?php echo htmlspecialchars($order['status']); ?></strong></p>

    <form method="post" style="max-width:400px;">
        <div class="form-group">
            <label for="status">Cập nhật trạng thái</label>
            <select name="status" id="status" class="form-control">
                <?php foreach (['pending','paid','shipping','completed','cancelled'] as $s): ?>
                    <option value="<?php echo $s; ?>" <?php echo ($order['status']==$s)?'selected':''; ?>><?php echo $s; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a href="index.php?page=admin_orders" class="btn btn-secondary">Quay lại</a>
    </form>

    <h4 class="mt-4">Sản phẩm</h4>
    <?php if (count($order['items']) > 0): ?>
        <table class="table">
            <thead><tr><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th></tr></thead>
            <tbody>
                <?php foreach ($order['items'] as $it): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($it['name']); ?></td>
                        <td><?php echo number_format($it['price'],0); ?>đ</td>
                        <td><?php echo intval($it['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có sản phẩm.</p>
    <?php endif; ?>

    <p class="mt-3"><strong>Tổng: <?php echo number_format($order['total_amount'],0); ?>đ</strong></p>
</div>
