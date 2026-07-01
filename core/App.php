<?php
/**
 * Lớp Điều hướng Ứng dụng
 * Xử lý điều hướng và tải controller
 */
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];
    
    // Ánh xạ từ tham số page sang controller/method
    protected $routes = [
        // Trang chủ
        'home' => ['HomeController', 'index'],
        'search' => ['HomeController', 'search'],
        
        // Sản phẩm
        'product' => ['ProductController', 'detail'],
        'product_add' => ['ProductController', 'add'],
        'product_sua' => ['ProductController', 'edit'],
        'product_del' => ['ProductController', 'delete'],
        
        // Danh mục
        'category' => ['CategoryController', 'index'],
        'admin_categories' => ['CategoryController', 'admin'],
        'category_add' => ['CategoryController', 'add'],
        'category_edit' => ['CategoryController', 'edit'],
        'category_delete' => ['CategoryController', 'delete'],
        
        // Giỏ hàng
        'cart' => ['CartController', 'index'],
        'cart_add' => ['CartController', 'add'],
        'cart_update' => ['CartController', 'update'],
        'cart_remove' => ['CartController', 'remove'],
        
        // Người dùng/Xác thực
        'login' => ['UserController', 'login'],
        'register' => ['UserController', 'register'],
        'logout' => ['UserController', 'logout'],
        'profile' => ['UserController', 'profile'],
        'profile_edit' => ['UserController', 'profileEdit'],
        'profile_password' => ['UserController', 'profilePassword'],
        'edit_profile' => ['UserController', 'profileEdit'],
        
        // Đơn hàng
        'payment' => ['OrderController', 'payment'],
        'admin_orders' => ['OrderController', 'admin'],
        'order_view' => ['OrderController', 'detail'],
        'lichsu' => ['OrderController', 'history'],
        
        // Đối tác
        'admin_partners' => ['PartnerController', 'admin'],
        'partner_add' => ['PartnerController', 'add'],
        'partner_edit' => ['PartnerController', 'edit'],
        'partner_delete' => ['PartnerController', 'delete'],
        'partners_detail' => ['PartnerController', 'detail'],
        
        // Nhân viên
        'admin_staff' => ['StaffController', 'admin'],
        'staff_add' => ['StaffController', 'add'],
        'staff_edit' => ['StaffController', 'edit'],
        'staff_delete' => ['StaffController', 'delete'],
        
        // Đánh giá
        'review_add' => ['ReviewController', 'add'],
        'review_del' => ['ReviewController', 'delete'],
        
        // Tin tức
        'news' => ['NewsController', 'index'],
        'news_add' => ['NewsController', 'add'],
        
        // Trang tĩnh
        'about_us' => ['PageController', 'aboutUs'],
        'contact' => ['PageController', 'contact'],
    ];
    
    public function __construct() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        // Lấy controller và method từ routes
        if (isset($this->routes[$page])) {
            $this->controller = $this->routes[$page][0];
            $this->method = $this->routes[$page][1];
        } else {
            // Mặc định là trang chủ
            $this->controller = 'HomeController';
            $this->method = 'index';
        }
        
        // Tải file controller
        $controllerFile = __DIR__ . '/../controllers/' . $this->controller . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = new $this->controller();
        } else {
            // Dự phòng trở về HomeController
            require_once __DIR__ . '/../controllers/HomeController.php';
            $this->controller = new HomeController();
            $this->method = 'index';
        }
        
        // Kiểm tra method có tồn tại
        if (!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }
        
        // Gọi method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
?>
