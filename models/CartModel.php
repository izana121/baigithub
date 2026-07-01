<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Giỏ hàng
 */
class CartModel extends Model {
    protected $table = 'carts';
    
    /**
     * Lấy giỏ hàng của người dùng
     */
    public function getCartByUser($userId) {
        $userId = intval($userId);
        $sql = "SELECT id FROM carts WHERE user_id = {$userId} LIMIT 1";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Tạo giỏ hàng cho người dùng
     */
    public function createCart($userId) {
        $userId = intval($userId);
        $this->conn->query("INSERT INTO carts (user_id) VALUES ({$userId})");
        return $this->conn->insert_id;
    }
    
    /**
     * Lấy hoặc tạo giỏ hàng cho người dùng
     */
    public function getOrCreateCart($userId) {
        $cart = $this->getCartByUser($userId);
        
        if ($cart) {
            return $cart['id'];
        }
        
        return $this->createCart($userId);
    }
    
    /**
     * Lấy các sản phẩm trong giỏ hàng với chi tiết
     */
    public function getCartItems($cartId) {
        $cartId = intval($cartId);
        $sql = "SELECT ci.id AS cart_item_id, ci.quantity, p.id AS product_id, p.name, p.price, p.image, p.stock
                FROM cart_items ci
                JOIN products p ON p.id = ci.product_id
                WHERE ci.cart_id = {$cartId}";
        
        $result = $this->conn->query($sql);
        $items = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['subtotal'] = $row['quantity'] * $row['price'];
                $items[] = $row;
            }
        }
        
        return $items;
    }
    
    /**
     * Lấy sản phẩm trong giỏ hàng
     */
    public function getCartItem($cartId, $productId) {
        $cartId = intval($cartId);
        $productId = intval($productId);
        
        $sql = "SELECT id, quantity FROM cart_items WHERE cart_id = {$cartId} AND product_id = {$productId} LIMIT 1";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addItem($cartId, $productId, $quantity = 1) {
        $cartId = intval($cartId);
        $productId = intval($productId);
        $quantity = max(1, intval($quantity));
        
        $existingItem = $this->getCartItem($cartId, $productId);
        
        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            return $this->updateItemQuantity($existingItem['id'], $newQuantity);
        } else {
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ({$cartId}, {$productId}, {$quantity})";
            return $this->conn->query($sql);
        }
    }
    
    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateItemQuantity($cartItemId, $quantity) {
        $cartItemId = intval($cartItemId);
        $quantity = max(1, intval($quantity));
        
        $sql = "UPDATE cart_items SET quantity = {$quantity} WHERE id = {$cartItemId}";
        return $this->conn->query($sql);
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeItem($cartItemId) {
        $cartItemId = intval($cartItemId);
        $sql = "DELETE FROM cart_items WHERE id = {$cartItemId}";
        return $this->conn->query($sql);
    }
    
    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart($cartId) {
        $cartId = intval($cartId);
        $sql = "DELETE FROM cart_items WHERE cart_id = {$cartId}";
        return $this->conn->query($sql);
    }
    
    /**
     * Tính tổng tiền giỏ hàng
     */
    public function getCartTotal($cartId) {
        $items = $this->getCartItems($cartId);
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        
        return $total;
    }
}
?>
