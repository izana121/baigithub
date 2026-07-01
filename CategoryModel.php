<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Category Model
 */
class CategoryModel extends Model {
    protected $table = 'categories';
    
    /**
     * Get featured categories
     */
    public function getFeatured($limit = 6) {
        return $this->findAll('id ASC', $limit);
    }
    
    /**
     * Get all categories for menu
     */
    public function getAllForMenu() {
        return $this->findAll('id ASC');
    }
    
    /**
     * Get category by ID
     */
    public function getCategory($id) {
        return $this->findById($id);
    }
    
    /**
     * Add category
     */
    public function addCategory($name) {
        return $this->insert(['name' => $name]);
    }
    
    /**
     * Update category
     */
    public function updateCategory($id, $name) {
        return $this->update($id, ['name' => $name]);
    }
    
    /**
     * Delete category
     */
    public function deleteCategory($id) {
        $id = intval($id);
       
        $sql = "SELECT id FROM products WHERE category_id = {$id}";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            // Delete related data for each product
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['id'];
                
                // Delete cart_items
                $this->conn->query("DELETE FROM cart_items WHERE product_id = {$product_id}");
                
                // Delete order_items
                $this->conn->query("DELETE FROM order_items WHERE product_id = {$product_id}");
                
                // Delete reviews
                $this->conn->query("DELETE FROM reviews WHERE product_id = {$product_id}");
            }
            
            // Delete all products in this category
            $this->conn->query("DELETE FROM products WHERE category_id = {$id}");
        }
        
        // Now delete the category
        return $this->delete($id);
    }
}
?>
