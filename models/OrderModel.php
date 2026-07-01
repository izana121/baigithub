<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Đơn hàng
 */
class OrderModel extends Model {
    protected $table = 'orders';
    
    /**
     * Lấy đơn hàng theo người dùng
     */
    public function getOrdersByUser($userId) {
        $userId = intval($userId);
        $sql = "SELECT * FROM orders WHERE user_id = {$userId} ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    
    /**
     * Lấy tất cả đơn hàng với thông tin người dùng
     */
    public function getAllOrders() {
        $sql = "SELECT o.*, u.username 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
    
    /**
     * Lấy chi tiết đơn hàng với sản phẩm
     */
    public function getOrderDetail($orderId) {
        $orderId = intval($orderId);
        
        // Lấy thông tin đơn hàng
        $order = $this->findById($orderId);
        
        if (!$order) {
            return null;
        }
        
        // Lấy sản phẩm trong đơn hàng
        $sql = "SELECT oi.*, p.name, p.image 
                FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = {$orderId}";
        $result = $this->conn->query($sql);
        $items = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        
        $order['items'] = $items;
        
        return $order;
    }
    
    /**
     * Lấy chi tiết đơn hàng với thông tin người dùng và sản phẩm
     */
    public function getOrderDetailWithUser($orderId) {
        $orderId = intval($orderId);
        
        // Lấy đơn hàng với thông tin người dùng
        $sql = "SELECT o.*, u.username, u.email 
                FROM orders o 
                LEFT JOIN users u ON u.id = o.user_id 
                WHERE o.id = {$orderId} 
                LIMIT 1";
        $result = $this->conn->query($sql);
        
        if (!$result || $result->num_rows == 0) {
            return null;
        }
        
        $order = $result->fetch_assoc();
        
        // Lấy sản phẩm trong đơn hàng
        $sql = "SELECT oi.*, p.name 
                FROM order_items oi 
                LEFT JOIN products p ON p.id = oi.product_id 
                WHERE oi.order_id = {$orderId}";
        $result = $this->conn->query($sql);
        $items = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        
        $order['items'] = $items;
        
        return $order;
    }
    
    /**
     * Tạo đơn hàng mới
     */
    public function createOrder($userId, $totalAmount, $status = 'pending') {
        return $this->insert([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => $status
        ]);
    }
    
    /**
     * Thêm sản phẩm vào đơn hàng
     */
    public function addOrderItem($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (" . intval($orderId) . ", " . intval($productId) . ", " . intval($quantity) . ", " . floatval($price) . ")";
        return $this->conn->query($sql);
    }
    
    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus($orderId, $status) {
        return $this->update($orderId, ['status' => $status]);
    }
    
    /**
     * Tạo đơn hàng từ giỏ hàng
     */
    public function createFromCart($userId, $cartItems, $total) {
        $orderId = $this->createOrder($userId, $total);
        
        if (!$orderId) {
            return false;
        }
        
        foreach ($cartItems as $item) {
            $this->addOrderItem($orderId, $item['product_id'], $item['quantity'], $item['price']);
        }
        
        return $orderId;
    }
}
?>
