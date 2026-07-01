<?php if ($success): ?>
    <div class="container mt-4">
        <div class="alert alert-success"><?php echo $success; ?></div>
        <a href="index.php?page=lichsu" class="btn btn-primary">Xem lịch sử đơn hàng</a>
    </div>
<?php else: ?>

<div class="container mt-4">
    <h3>Thanh toán</h3>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (empty($items)): ?>
        <div class="alert alert-warning">Giỏ hàng trống.</div>
        <a href="index.php?page=home" class="btn btn-primary">Tiếp tục mua sắm</a>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?= htmlspecialchars($it['name']) ?></td>
                        <td><?= number_format($it['price'],0) ?>đ</td>
                        <td><?= $it['quantity'] ?></td>
                        <td><?= number_format($it['price']*$it['quantity'],0) ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Tổng: <?= number_format($total,0) ?>đ</strong></p>

        <form method="post" class="mt-3">
            <div class="mb-3">
                <label class="form-label">Phương thức thanh toán</label>

                <div class="row">
                    <div class="col-md-6">
                        <label class="card p-3 mb-3 d-flex align-items-center">
                            <input type="radio" name="phuongthuc" value="cod" required class="me-2">
                            <img src="images/cod.png" alt="COD" class="me-2" style="width:60px;height:40px;object-fit:contain;">
                            <span class="fw-bold">COD</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="card p-3 mb-3 d-flex align-items-center">
                            <input type="radio" name="phuongthuc" value="Banking" required class="me-2">
                            <img src="images/bank.png" alt="Banking" class="me-2" style="width:60px;height:40px;object-fit:contain;">
                            <span class="fw-bold">Chuyển khoản</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="card p-3 mb-3 d-flex align-items-center">
                            <input type="radio" name="phuongthuc" value="MoMo" required class="me-2">
                            <img src="images/momo-logo.png" alt="MoMo" class="me-2" style="width:60px;height:40px;object-fit:contain;">
                            <span class="fw-bold">MoMo</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="card p-3 mb-3 d-flex align-items-center">
                            <input type="radio" name="phuongthuc" value="VNpay" required class="me-2">
                            <img src="images/vnpay-logo.png" alt="VNPay" class="me-2" style="width:60px;height:40px;object-fit:contain;">
                            <span class="fw-bold">VNPay</span>
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Xác nhận đặt hàng</button>
        </form>
    <?php endif; ?>
</div>

<?php endif; ?>
