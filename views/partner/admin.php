<link rel="stylesheet" href="css/partners.css">
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Quản lý Đối tác</h1>
        <a href="index.php?page=partner_add" class="btn btn-success">+ Thêm Đối tác</a>
    </div>

    <div class="table-container">
        <?php if (!empty($partners)): ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($partners as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['description'] ?? '') ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="index.php?page=partners_detail&id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-info">
                                   Chi tiết
                                </a>
                                <a href="index.php?page=partner_edit&id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-primary">Sửa</a>
                                <a href="index.php?page=partner_delete&id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Chưa có đối tác nào.</div>
        <?php endif; ?>
    </div>
</div>
