<div class="container mt-4">
    <h3>Chi tiết đơn hàng #<?php echo $order['id'] ?? ''; ?></h3>
    
    <?php if ($order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Mã đơn:</strong> #<?php echo $order['id']; ?></p>
                <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total_amount'], 0); ?>đ</p>
                <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
            </div>
        </div>
        
        <h4>Sản phẩm</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" style="width:50px;height:50px;object-fit:cover;margin-right:8px;">
                            <?php endif; ?>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </td>
                        <td><?php echo number_format($item['price'], 0); ?>đ</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], 0); ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">Không tìm thấy đơn hàng.</div>
    <?php endif; ?>
    
    <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
</div>
