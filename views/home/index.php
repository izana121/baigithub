<?php
$page = $current_page;
$featured_products = $products;
$total_products = count($products) * $total_pages;
?>

<link rel="stylesheet" href="css/home.css">

<div class="banner-slider">
    <div class="banner-slide active">
        <img src="images/bang-ron-2026-tet-binh-ngo.png" alt="Máy lạnh giảm sốc">
    </div>
    <div class="banner-slide">
        <img src="images/banner-ngang-1.png" alt="Máy lạnh LG Inverter">
    </div>
    <div class="banner-slide">
        <img src="images/banner-ngang-2.png" alt="Mua Panasonic trúng xe điện">
    </div>
    
    <div class="banner-dots">
        <span class="dot active" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
</div>

<!-- Search Bar -->
<div class="search-container">
    <form action="index.php" method="get" class="search-form">
        <input type="hidden" name="page" value="search">
        <div class="search-input-wrapper">
            <input 
                type="text" 
                name="q" 
                class="search-input" 
                placeholder="Tìm kiếm sản phẩm..." 
                value="<?= isset($search_keyword) ? htmlspecialchars($search_keyword) : '' ?>"
            >
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </div>
    </form>
    <?php if (isset($search_keyword) && !empty($search_keyword)): ?>
        <div class="search-result-info">
            Kết quả tìm kiếm cho: "<strong><?= htmlspecialchars($search_keyword) ?></strong>"
            <a href="index.php?page=home" class="clear-search">Xóa tìm kiếm</a>
        </div>
    <?php endif; ?>
</div>

<div class="home-container">
    <?php if ($page == 1): ?>
    <!-- Categories Section -->
    <h2 class="section-title">Danh mục nổi bật</h2>
    <div class="categories-grid">
        <?php 
        if (!empty($categories)):
            foreach($categories as $cat): 
        ?>
            <a href="index.php?page=category&id=<?= $cat['id'] ?>" class="category-card">
                <div class="category-name" style="font-size: 16px;"><?= htmlspecialchars($cat['name']) ?></div>
            </a>
        <?php 
            endforeach;
        endif;
        ?>
    </div>
    <?php endif; ?>

    <!-- Featured Products -->
    <h2 class="section-title"> Sản phẩm nổi bật</h2>
    
    <div class="<?= ($page == 1 && (!isset($search_keyword) || empty($search_keyword))) ? 'categories-wrapper' : 'products-wrapper' ?>">
        <?php if ($page == 1 && (!isset($search_keyword) || empty($search_keyword))): ?>
        <div class="category-banner">
            <img src="images/Banner-doc.png" alt="Banner Điện tử - Điện lạnh">
        </div>
        <?php endif; ?>
        
        <div class="products-grid <?= count($featured_products) <= 3 ? 'products-grid-small' : '' ?>">
            <?php 
            if (count($featured_products) > 0):
                foreach($featured_products as $product): 
            ?>
                <div class="product-card" onclick="viewProduct(<?= $product['id'] ?>)">
                    
                    <?php if ($product['stock'] > 0): ?>
                        <div class="stock-badge <?= $product['stock'] < 10 ? 'low' : '' ?>">
                            Còn <?= $product['stock'] ?> SP
                        </div>
                    <?php endif; ?>

                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else: ?>
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff;">
                                Không có ảnh
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-info">
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="product-price">
                            <span class="price-new"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                        </div>
                        <form method="post" action="index.php?page=cart_add" style="display:inline;" onsubmit="event.stopPropagation();">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button class="add-to-cart-btn" type="submit">🛒 Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #7f8c8d;">
                    <p style="font-size: 18px;">Không có sản phẩm nào</p>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <a href="index.php?page=home&p=<?= $page - 1 ?>">← Trước</a>
            <?php else: ?>
                <a href="#" class="disabled">← Trước</a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php
            // Hiển thị tối đa 7 trang
            $range = 2; // Số trang hiển thị mỗi bên
            $start = max(1, $page - $range);
            $end = min($total_pages, $page + $range);

            // Trang đầu
            if ($start > 1): ?>
                <a href="index.php?page=home&p=1">1</a>
                <?php if ($start > 2): ?>
                    <span class="page-info">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Các trang ở giữa -->
            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="index.php?page=home&p=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <!-- Trang cuối -->
            <?php if ($end < $total_pages): ?>
                <?php if ($end < $total_pages - 1): ?>
                    <span class="page-info">...</span>
                <?php endif; ?>
                <a href="index.php?page=home&p=<?= $total_pages ?>"><?= $total_pages ?></a>
            <?php endif; ?>

            <!-- Next Button -->
            <?php if ($page < $total_pages): ?>
                <a href="index.php?page=home&p=<?= $page + 1 ?>">Sau →</a>
            <?php else: ?>
                <a href="#" class="disabled">Sau →</a>
            <?php endif; ?>

            <!-- Page Info -->
            <span class="page-info">
                Trang <?= $page ?>/<?= $total_pages ?>
            </span>
        </div>
    <?php endif; ?>
</div>

<script>
    // Banner Slider
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlideIndex = (currentSlideIndex + 1) % slides.length;
        showSlide(currentSlideIndex);
    }

    function currentSlide(index) {
        currentSlideIndex = index;
        showSlide(index);
    }

    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);

    // View Product Detail
    function viewProduct(productId) {
        window.location.href = 'index.php?page=product&id=' + productId;
    }

    // Scroll to top when changing page
    if (window.location.search.includes('p=')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
