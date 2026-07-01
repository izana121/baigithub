<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Sản phẩm
 */
class ProductController extends Controller {
    private $productModel;
    private $reviewModel;
    private $categoryModel;
    private $partnerModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('ProductModel');
        $this->reviewModel = $this->model('ReviewModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->partnerModel = $this->model('PartnerModel');
    }
    
    /**
     * Trang chi tiết sản phẩm
     */
    public function detail() {
        $product_id = $this->get('id', 0);
        $product = null;
        $reviews = [];
        
        if ($product_id > 0) {
            $product = $this->productModel->getProductDetail($product_id);
            $reviews = $this->reviewModel->getByProduct($product_id);
        }
        
        $this->view('product/detail', [
            'product' => $product,
            'product_id' => $product_id,
            'reviews' => $reviews,
            'isAdmin' => $this->isAdmin()
        ]);
    }
    
    /**
     * Trang thêm sản phẩm
     */
    public function add() {
        $this->requireAdmin();
        
        $category_id = $this->get('category_id', 0);
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            $price = $this->post('price');
            $stock = $this->post('stock');
            $description = $this->post('description');
            $manufacturer_id = $this->post('manufacturer_id');
            $category_id = $this->post('category_id');
            
            // Xử lý upload ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../images/' . $image);
            }
            
            $result = $this->productModel->addProduct([
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'description' => $description,
                'image' => $image,
                'manufacturer_id' => $manufacturer_id,
                'category_id' => $category_id
            ]);
            
            if ($result) {
                echo '<script>window.location.href="index.php?page=category&id=' . $category_id . '";</script>';
                exit;
            } else {
                $error = 'Thêm sản phẩm thất bại';
            }
        }
        
        $categories = $this->categoryModel->findAll();
        $partners = $this->partnerModel->getAllPartners();
        
        $this->view('product/add', [
            'category_id' => $category_id,
            'categories' => $categories,
            'partners' => $partners,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Edit product page
     */
    public function edit() {
        $this->requireAdmin();
        
        $product_id = $this->get('id', 0);
        $product = $this->productModel->findById($product_id);
        
        if (!$product) {
            $this->redirect('index.php?page=home');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            $price = $this->post('price');
            $stock = $this->post('stock');
            $description = $this->post('description');
            $manufacturer_id = $this->post('manufacturer_id');
            $category_id = $this->post('category_id');
            
            // Validate manufacturer_id
            if (empty($manufacturer_id)) {
                $error = 'Vui lòng chọn nhà sản xuất';
            }
            
            if (empty($error)) {
                $data = [
                    'name' => $name,
                    'price' => $price,
                    'stock' => $stock,
                    'description' => $description,
                    'manufacturer_id' => $manufacturer_id,
                    'category_id' => $category_id
                ];
            
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $image = time() . '_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../images/' . $image);
                    $data['image'] = $image;
                }
                
                $result = $this->productModel->updateProduct($product_id, $data);
                
                if ($result) {
                    $success = 'Cập nhật thành công';
                    $product = $this->productModel->findById($product_id);
                } else {
                    $error = 'Cập nhật thất bại';
                }
            }
        }
        
        $categories = $this->categoryModel->findAll();
        $partners = $this->partnerModel->getAllPartners();
        
        $this->view('product/edit', [
            'product' => $product,
            'categories' => $categories,
            'partners' => $partners,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Delete product
     */
    public function delete() {
        $this->requireAdmin();
        
        $product_id = $this->get('id', 0);
        $product = $this->productModel->findById($product_id);
        
        if (!$product) {
            $this->redirect('index.php?page=home');
            return;
        }
        
        // If confirmed, delete the product
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->post('confirm')) {
            $category_id = $product['category_id'];
            $this->productModel->deleteProduct($product_id);
            echo '<script>window.location.href="index.php?page=category&id=' . $category_id . '";</script>';
            exit;
        }
        
        // Show confirmation page
        $this->view('product/delete', [
            'product' => $product
        ]);
    }
}
?>
