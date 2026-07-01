<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * User Model
 */
class UserModel extends Model {
    protected $table = 'users';
    
    /**
     * Find user by username
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
     * Check if username or email exists
     */
    public function exists($username, $email) {
        $username = $this->conn->real_escape_string($username);
        $email = $this->conn->real_escape_string($email);
        
        $sql = "SELECT id FROM users WHERE username = '{$username}' OR email = '{$email}'";
        $result = $this->conn->query($sql);
        
        return $result && $result->num_rows > 0;
    }
    
    /**
     * Register new user
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
     * Verify login
     */public function verifyLogin($username, $password) {
    $user = $this->findByUsername($username);
    
    if ($user) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }

        if ($password === $user['password']) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $newHash, $user['id']);
            $stmt->execute();

            return $user;
        }
    }
    
    return null;
}
    /**
     * Update profile
     */
    public function updateProfile($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Get all staff (admin users)
     */
    public function getStaff() {
        return $this->findAll();
    }
    
    /**
     * Get all customers
     */
    public function getCustomers() {
        return $this->findWhere(['role' => 'customer']);
    }
    
    /**
     * Delete user and all related data
     */
    public function deleteUser($id) {
        $id = intval($id);
        
        // Delete related cart_items first
        $this->conn->query("DELETE ci FROM cart_items ci INNER JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = {$id}");
        
        // Delete related carts
        $this->conn->query("DELETE FROM carts WHERE user_id = {$id}");
        
        // Delete related reviews
        $this->conn->query("DELETE FROM reviews WHERE user_id = {$id}");
        
        // Delete related order_items
        $this->conn->query("DELETE oi FROM order_items oi INNER JOIN orders o ON oi.order_id = o.id WHERE o.user_id = {$id}");
        
        // Delete related payments
        $this->conn->query("DELETE p FROM payments p INNER JOIN orders o ON p.order_id = o.id WHERE o.user_id = {$id}");
        
        // Delete related orders
        $this->conn->query("DELETE FROM orders WHERE user_id = {$id}");
        
        // Now delete the user
        return $this->delete($id);
    }
}
?>
