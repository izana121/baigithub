<?php
$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<div class="container mt-4">
    <h2>Tin tức mới nhất</h2>

    <?php if (!empty($deleteMessage)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($deleteMessage) ?></div>
    <?php endif; ?>

    <?php if (!empty($news)): ?>
        <?php foreach ($news as $row): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($row['title']) ?>

                        <?php if ($role === 'admin' || $username === 'test'): ?>
                            <form method="POST" action="index.php?page=news" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa tin này?')">
                                    Xóa
                                </button>
                            </form>
                        <?php endif; ?>
                    </h5>

                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>"
                             class="img-fluid mb-2"
                             style="max-width:300px;"
                             alt="Ảnh minh họa">
                    <?php endif; ?>

                    <p class="card-text"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <small class="text-muted">Đăng ngày: <?= $row['created_at'] ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có tin tức nào.</p>
    <?php endif; ?>
</div>

<style> 
body {
    background-color: #ffffff;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    color: #1f2937;
    line-height: 1.6;
} 
.container {
    max-width: 960px;
    margin: 2rem auto;
    padding: 0 1rem;
} 
.container h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    color: #d32f2f;
} 
.card { 
    background-color: #ffffff;
    border: 1px solid #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    transition: box-shadow 0.2s ease;
} 
.card:hover {
     box-shadow: 0 8px 20px rgba(0,0,0,0.12);
} 
.card-body {
    padding: 1rem 1.25rem;
}  
.card-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.75rem;
    color: #1f2937;
}  
.card-text {
    font-size: 1rem;
    color: #374151;
    margin-bottom: 0.75rem;
}
.card-body img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 1rem;
}
.text-muted {
    color: #6b7280 !important;
    font-size: 0.875rem;
} 
.alert {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
}
.alert-info {
    background-color: #e3f2fd;
    color: #0d47a1;
    border: 1px solid #90caf9;
}
.btn-danger {
    background-color: #d32f2f;
    border: none;
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease;
} 
.btn-danger:hover {
    background-color: #b71c1c;
    transform: translateY(-1px);
} 
.btn-danger:active {
    transform: translateY(0);
} 
</style>
</style>
