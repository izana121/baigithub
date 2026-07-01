<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Người dùng
 */
class UserModel extends Model {
    protected $table = 'users';
    
    /**
     * Tìm người dùng theo tên đăng nhập
     */
    public function findByUsername($username) {
        $username = $this->conn->real_escape_string($username);
        $sql = "SELECT * FROM users WHERE username = '{$username}' OR email = '{$username}'";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Kiểm tra tên đăng nhập hoặc email đã tồn tại
     */
    public function exists($username, $email) {
        $username = $this->conn->real_escape_string($username);
        $email = $this->conn->real_escape_string($email);
        
        $sql = "SELECT id FROM users WHERE username = '{$username}' OR email = '{$email}'";
        $result = $this->conn->query($sql);
        
        return $result && $result->num_rows > 0;
    }
    
    /**
     * Đăng ký người dùng mới
     */
    public function register($username, $email, $password, $role = 'customer') {
        return $this->insert([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
    }
    
    /**
     * Xác thực đăng nhập
     */
    public function verifyLogin($username, $password) {
        $user = $this->findByUsername($username);
        
        if ($user && $password === $user['password']) {
            return $user;
        }
        
        return null;
    }
    
    /**
     * Cập nhật hồ sơ
     */
    public function updateProfile($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Lấy tất cả nhân viên (admin)
     */
    public function getStaff() {
        return $this->findAll();
    }
    
    /**
     * Lấy tất cả khách hàng
     */
    public function getCustomers() {
        return $this->findWhere(['role' => 'customer']);
    }
    
    /**
     * Xóa người dùng và tất cả dữ liệu liên quan
     */
    public function deleteUser($id) {
        $id = intval($id);
        
        // Xóa cart_items liên quan trước
        $this->conn->query("DELETE ci FROM cart_items ci INNER JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = {$id}");
        
        // Xóa giỏ hàng liên quan
        $this->conn->query("DELETE FROM carts WHERE user_id = {$id}");
        
        // Xóa đánh giá liên quan
        $this->conn->query("DELETE FROM reviews WHERE user_id = {$id}");
        
        // Xóa order_items liên quan
        $this->conn->query("DELETE oi FROM order_items oi INNER JOIN orders o ON oi.order_id = o.id WHERE o.user_id = {$id}");
        
        // Xóa thanh toán liên quan
        $this->conn->query("DELETE p FROM payments p INNER JOIN orders o ON p.order_id = o.id WHERE o.user_id = {$id}");
        
        // Xóa đơn hàng liên quan
        $this->conn->query("DELETE FROM orders WHERE user_id = {$id}");
        
        // Cuối cùng xóa người dùng
        return $this->delete($id);
    }
}
?>
