<div class="container mt-4">
    <h2>Thêm Tin Tức Mới</h2>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div> 
        <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
        </div> 
        <div class="form-group">
            <label for="image">Ảnh minh họa (tuỳ chọn)</label> 
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*"> 
        </div> 
        <button type="submit" class="btn btn-success">Đăng tin</button> 
    </form> 
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
.alert { 
    border-radius: 8px; 
    padding: 0.75rem 1rem; 
    margin-bottom: 1rem; 
} 
.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.btn-success {
    background-color: #388e3c;
    border: none;
    color: #fff;
    font-weight: bold;
    border-radius: 6px;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-success:hover {
    background-color: #2e7d32;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-1px);
}
</style>
