<?php
/**
 * Application Router Class
 * Handle routing and controller loading
 */
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];
    
    // Mapping from page parameter to controller/method
    protected $routes = [
        // Home
        'home' => ['HomeController', 'index'],
        'search' => ['HomeController', 'search'],
        
        // Products
        'product' => ['ProductController', 'detail'],
        'product_add' => ['ProductController', 'add'],
        'product_sua' => ['ProductController', 'edit'],
        'product_del' => ['ProductController', 'delete'],
        
        // Categories
        'category' => ['CategoryController', 'index'],
        'admin_categories' => ['CategoryController', 'admin'],
        'category_add' => ['CategoryController', 'add'],
        'category_edit' => ['CategoryController', 'edit'],
        'category_delete' => ['CategoryController', 'delete'],
        
        // Cart
        'cart' => ['CartController', 'index'],
        'cart_add' => ['CartController', 'add'],
        'cart_update' => ['CartController', 'update'],
        'cart_remove' => ['CartController', 'remove'],
        
        // User/Auth
        'login' => ['UserController', 'login'],
        'register' => ['UserController', 'register'],
        'logout' => ['UserController', 'logout'],
        'profile' => ['UserController', 'profile'],
        'profile_edit' => ['UserController', 'profileEdit'],
        'profile_password' => ['UserController', 'profilePassword'],
        'edit_profile' => ['UserController', 'profileEdit'],
        
        // Orders
        'payment' => ['OrderController', 'payment'],
        'admin_orders' => ['OrderController', 'admin'],
        'order_view' => ['OrderController', 'detail'],
        'lichsu' => ['OrderController', 'history'],
        
        // API Đơn hàng
        'order_api_list' => ['OrderApi', 'apiList'],
        'order_api_view' => ['OrderApi', 'apiView'],
        'order_api_update' => ['OrderApi', 'apiUpdate'],
        'order_api_delete' => ['OrderApi', 'apiDelete'],

         // API Payment (Thêm mới độc lập)
        'payment_api_vnpay_url' => ['PaymentApi', 'createVnpayUrl'],
        'payment_api_vnpay_ipn' => ['PaymentApi', 'vnpayIpn'],
        
        // Partners
        'admin_partners' => ['PartnerController', 'admin'],
        'partner_add' => ['PartnerController', 'add'],
        'partner_edit' => ['PartnerController', 'edit'],
        'partner_delete' => ['PartnerController', 'delete'],
        'partners_detail' => ['PartnerController', 'detail'],
        
        // Staff
        'admin_staff' => ['StaffController', 'admin'],
        'staff_add' => ['StaffController', 'add'],
        'staff_edit' => ['StaffController', 'edit'],
        'staff_delete' => ['StaffController', 'delete'],
        
        // Reviews
        'review_add' => ['ReviewController', 'add'],
        'review_del' => ['ReviewController', 'delete'],
        
        // News
        'admin_news' => ['AdminNewsController', 'index'],
        'news_add' => ['AdminNewsController', 'create'],
        'admin_news_delete' => ['AdminNewsController', 'delete'],
        
        // Static pages
        'about_us' => ['PageController', 'aboutUs'],
        'contact' => ['PageController', 'contact'],
    ];
    
    public function __construct() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        // Get controller and method from routes
        if (isset($this->routes[$page])) {
            $this->controller = $this->routes[$page][0];
            $this->method = $this->routes[$page][1];
        } else {
            // Default to home
            $this->controller = 'HomeController';
            $this->method = 'index';
        }
        
        // Load controller file
        $controllerFile = __DIR__ . '/../controllers/' . $this->controller . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = new $this->controller();
        } else {
            // Fallback to HomeController
            require_once __DIR__ . '/../controllers/HomeController.php';
            $this->controller = new HomeController();
            $this->method = 'index';
        }
        
        // Check if method exists
        if (!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }
        
        // Call the method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
?>
