<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Giỏ hàng
 */
class CartController extends Controller {
    private $cartModel;
    
    public function __construct() {
        parent::__construct();
        $this->cartModel = $this->model('CartModel');
    }
    
    /**
     * Trang giỏ hàng
     */
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->view('cart/login_required');
            return;
        }
        
        $user_id = $this->getUserId();
        $cart_id = $this->cartModel->getOrCreateCart($user_id);
        $items = $this->cartModel->getCartItems($cart_id);
        $total = $this->cartModel->getCartTotal($cart_id);
        
        $this->view('cart/index', [
            'items' => $items,
            'total' => $total
        ]);
    }
    
    /**
     * Thêm vào giỏ hàng
     */
    public function add() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?page=login');
        }
        
        $user_id = $this->getUserId();
        $product_id = $this->request('product_id', 0);
        $quantity = $this->request('quantity', 1);
        
        if ($product_id <= 0) {
            $this->redirect('index.php?page=home');
        }
        
        $cart_id = $this->cartModel->getOrCreateCart($user_id);
        $this->cartModel->addItem($cart_id, $product_id, $quantity);
        
        $this->redirect('index.php?page=cart');
    }
    
    /**
     * Cập nhật sản phẩm trong giỏ
     */
    public function update() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?page=login');
        }
        
        $cart_item_id = $this->post('cart_item_id', 0);
        $quantity = $this->post('quantity', 1);
        
        if ($cart_item_id > 0) {
            if ($quantity <= 0) {
                $this->cartModel->removeItem($cart_item_id);
            } else {
                $this->cartModel->updateItemQuantity($cart_item_id, $quantity);
            }
        }
        
        $this->redirect('index.php?page=cart');
    }
    
    /**
     * Xoá sản phẩm
     */
    public function remove() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?page=login');
        }
        
        $cart_item_id = $this->post('cart_item_id', 0);
        
        if ($cart_item_id > 0) {
            $this->cartModel->removeItem($cart_item_id);
        }
        
        $this->redirect('index.php?page=cart');
    }
}
?>
