<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Đơn hàng
 */
class OrderController extends Controller {
    private $orderModel;
    private $cartModel;
    
    public function __construct() {
        parent::__construct();
        $this->orderModel = $this->model('OrderModel');
        $this->cartModel = $this->model('CartModel');
    }
    
    /**
     * Trang thanh toán
     */
    public function payment() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        $cart_id = $this->cartModel->getOrCreateCart($user_id);
        $items = $this->cartModel->getCartItems($cart_id);
        $total = $this->cartModel->getCartTotal($cart_id);
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($items)) {
                $error = 'Giỏ hàng trống';
            } else {
                // Tạo đơn hàng
                $orderId = $this->orderModel->createFromCart($user_id, $items, $total);
                
                if ($orderId) {
                    // Clear cart
                    $this->cartModel->clearCart($cart_id);
                    $success = 'Đặt hàng thành công! Mã đơn hàng: #' . $orderId;
                    $items = [];
                    $total = 0;
                } else {
                    $error = 'Đặt hàng thất bại';
                }
            }
        }
        
        $this->view('order/payment', [
            'items' => $items,
            'total' => $total,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Danh sách đơn hàng (Admin)
     */
    public function admin() {
        $this->requireAdmin();
        
        $orders = $this->orderModel->getAllOrders();
        
        $this->view('order/admin', [
            'orders' => $orders
        ]);
    }
    
    /**
     * Xem chi tiết đơn hàng (Admin - có cập nhật trạng thái)
     */
    public function detail() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);
        if ($id <= 0) {
            $this->redirect('index.php?page=admin_orders');
        }
        
        // Handle status update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            $status = $this->post('status');
            $this->orderModel->updateStatus($id, $status);
        }
        
        $order = $this->orderModel->getOrderDetailWithUser($id);
        
        if (!$order) {
            $this->redirect('index.php?page=admin_orders');
        }
        
        $this->view('order/detail', [
            'order' => $order
        ]);
    }
    
    /**
     * Order history
     */
    public function history() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        $orders = $this->orderModel->getOrdersByUser($user_id);
        
        $this->view('order/history', [
            'orders' => $orders
        ]);
    }
}
?>
