<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Quản lý Người dùng</h3>
        <a href="index.php?page=staff_add" class="btn btn-success">Thêm người dùng</a>
    </div>

    <?php if (!empty($staff)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['role'] ?? ''); ?></td>
                        <td>
                            <a href="index.php?page=staff_edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="index.php?page=staff_delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Chưa có nhân viên nào.</div>
    <?php endif; ?>
</div>
