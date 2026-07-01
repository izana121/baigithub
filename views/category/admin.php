<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Quản lý Danh mục</h3>
        <a href="index.php?page=category_add" class="btn btn-success">Thêm danh mục</a>
    </div>

    <?php if (!empty($categories)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <a href="index.php?page=category_edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="index.php?page=category_delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Chưa có danh mục nào.</div>
    <?php endif; ?>
</div>
