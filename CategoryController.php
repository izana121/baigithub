<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Category Controller
 */
class CategoryController extends Controller {
    private $productModel; 

    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('ProductModel');
    }
    /**
     * Trang danh mục + sản phẩm
     */
    public function index() {
        $id = $this->get('id', 0);
        $search = $this->get('search', '');
        
       $categoryRes = $this->callAPI(
            "GET",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php?id=".$id
        );

$category = ($categoryRes && $categoryRes['success']) ? $categoryRes['data'] : null;
        
        // Quay lại trang trước nếu không thấy danh mục
        if (!$category) {
            echo '<script>history.back();</script>';
            exit;
        }
        
        $products = $this->productModel->getByCategory($id, $search);
        
        $this->view('category/index', [
            'category' => $category,
            'products' => $products,
            'search' => $search,
            'id' => $id,
            'isAdmin' => $this->isAdmin()
        ]);
    }
    
    /**
     * Danh sách danh mục của admin
     */
    public function admin() {
        $this->requireAdmin();
        
       $res = $this ->callAPI(
            "GET",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php"
       );

       $categories = ($res && $res['success']) ? $res['data'] : [];
        
        $this->view('category/admin', [
            'categories' => $categories
        ]);
    }
    
    /**
     * Add category
     */
    public function add() {
        $this->requireAdmin();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            
        if (!empty($name)) {
        $result = $this->callAPI(
            "POST",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php",
            ['name' => $name]
        );
                
            if ($result && $result['success']) {
                    $this->redirect('index.php?page=admin_categories');
                } else {
                    $error = 'Thêm danh mục thất bại';
                }
            } else {
                $error = 'Tên danh mục không được để trống';
            }
        }
        
        $this->view('category/add', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Edit category
     */
    public function edit() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);

       $res = $this->callAPI(
                    "GET",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php?id=".$id
                );

    $category = ($res && $res['success']) ? $res['data'] : null;
        
        if (!$category) {
            $this->redirect('index.php?page=admin_categories');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            
            if (!empty($name)) {

                $result = $this->callAPI(
                    "PUT",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php",
                    [
                        'id' => $id,
                        'name' => $name
                    ]
                );
                
               if ($result && $result['success']) {
                    $success = 'Cập nhật thành công';
                    $category['name'] = $name;
                } else {
                    $error = 'Cập nhật thất bại';
                }
            } else {
                $error = 'Tên danh mục không được để trống';
            }
        }
        
        $this->view('category/edit', [
            'category' => $category,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Delete category
     */
    public function delete() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);
        
        if ($id > 0) {

           $this->callAPI(
            "DELETE",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/category_api.php",
            ['id' => $id]
        );  
        }
        
        $this->redirect('index.php?page=admin_categories');
    }
}
?>
