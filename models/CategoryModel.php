<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Danh mục
 */
class CategoryModel extends Model {
    protected $table = 'categories';
    
    /**
     * Lấy danh mục nổi bật
     */
    public function getFeatured($limit = 6) {
        return $this->findAll('id ASC', $limit);
    }
    
    /**
     * Lấy tất cả danh mục cho menu
     */
    public function getAllForMenu() {
        return $this->findAll('id ASC');
    }
    
    /**
     * Lấy danh mục theo ID
     */
    public function getCategory($id) {
        return $this->findById($id);
    }
    
    /**
     * Thêm danh mục
     */
    public function addCategory($name) {
        return $this->insert(['name' => $name]);
    }
    
    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, $name) {
        return $this->update($id, ['name' => $name]);
    }
    
    /**
     * Xóa danh mục
     */
    public function deleteCategory($id) {
        $id = intval($id);
        
        // Đầu tiên, lấy tất cả sản phẩm trong danh mục này
        $sql = "SELECT id FROM products WHERE category_id = {$id}";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            // Xóa dữ liệu liên quan cho mỗi sản phẩm
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['id'];
                
                // Xóa cart_items
                $this->conn->query("DELETE FROM cart_items WHERE product_id = {$product_id}");
                
                // Xóa order_items
                $this->conn->query("DELETE FROM order_items WHERE product_id = {$product_id}");
                
                // Xóa đánh giá
                $this->conn->query("DELETE FROM reviews WHERE product_id = {$product_id}");
            }
            
            // Xóa tất cả sản phẩm trong danh mục này
            $this->conn->query("DELETE FROM products WHERE category_id = {$id}");
        }
        
        // Cuối cùng xóa danh mục
        return $this->delete($id);
    }
}
?>
