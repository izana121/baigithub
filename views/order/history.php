<div class="container mt-4">
    <h3>Lịch sử đơn hàng</h3>

    <?php if (!empty($orders)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo number_format($order['total_amount'], 0); ?>đ</td>
                        <td>
                            <?php 
                            $statusClass = [
                                'pending' => 'warning',
                                'paid' => 'info',
                                'shipping' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $status = $order['status'];
                            ?>
                            <span class="badge badge-<?php echo $statusClass[$status] ?? 'secondary'; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
        <a href="index.php?page=home" class="btn btn-primary">Tiếp tục mua sắm</a>
    <?php endif; ?>
</div>
