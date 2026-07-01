<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Trang chủ
 */
class HomeController extends Controller {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
    }
    
    /**
     * Trang chủ
     */
    public function index() {
        $limit = 12;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;
        
        // Lấy danh mục
        $categories = $this->categoryModel->getFeatured(6);
        
        // Lấy sản phẩm
        $products = $this->productModel->getProductsWithCategory($limit, $offset);
        
        // Lấy tổng số sản phẩm để phân trang
        $total_products = $this->productModel->count();
        $total_pages = ceil($total_products / $limit);
        
        $this->view('home/index', [
            'categories' => $categories,
            'products' => $products,
            'current_page' => $page,
            'total_pages' => $total_pages
        ]);
    }
    
    /**
     * Tìm kiếm sản phẩm
     */
    public function search() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $limit = 12;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $page = max($page, 1);
        $offset = ($page - 1) * $limit;
        
        // Lấy danh mục
        $categories = $this->categoryModel->getFeatured(6);
        
        if (!empty($keyword)) {
            // Tìm kiếm sản phẩm
            $products = $this->productModel->searchProducts($keyword, $limit, $offset);
            $total_products = $this->productModel->countSearchResults($keyword);
        } else {
            // Không có từ khóa, hiển thị tất cả sản phẩm
            $products = $this->productModel->getProductsWithCategory($limit, $offset);
            $total_products = $this->productModel->count();
        }
        
        $total_pages = ceil($total_products / $limit);
        
        $this->view('home/index', [
            'categories' => $categories,
            'products' => $products,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'search_keyword' => $keyword
        ]);
    }
}
?>
