<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Product Model
 */
class ProductModel extends Model {
    protected $table = 'products';
    
    /**
     * Get products with category name
     */
    public function getProductsWithCategory($limit = null, $offset = null, $orderBy = 'id DESC') {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY {$orderBy}";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . intval($limit);
            if ($offset !== null) {
                $sql .= " OFFSET " . intval($offset);
            }
        }
        
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
     * Get products by category
     */
    public function getByCategory($categoryId, $search = '') {
        $categoryId = intval($categoryId);
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = {$categoryId}";
        
        if (!empty($search)) {
            $search_safe = $this->conn->real_escape_string($search);
            $sql .= " AND (p.name LIKE '%{$search_safe}%' OR p.description LIKE '%{$search_safe}%')";
        }
        
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
     * Search products
     */
    public function searchProducts($keyword, $limit = null, $offset = null) {
        $keyword_safe = $this->conn->real_escape_string($keyword);
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE '%{$keyword_safe}%' 
                   OR p.description LIKE '%{$keyword_safe}%'
                   OR c.name LIKE '%{$keyword_safe}%'
                ORDER BY p.id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . intval($limit);
            if ($offset !== null) {
                $sql .= " OFFSET " . intval($offset);
            }
        }
        
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
     * Count search results
     */
    public function countSearchResults($keyword) {
        $keyword_safe = $this->conn->real_escape_string($keyword);
        $sql = "SELECT COUNT(*) as total
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE '%{$keyword_safe}%' 
                   OR p.description LIKE '%{$keyword_safe}%'
                   OR c.name LIKE '%{$keyword_safe}%'";
        
        $result = $this->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return (int) $row['total'];
        }
        
        return 0;
    }
    
    /**
     * Get product detail with manufacturer
     */
    public function getProductDetail($id) {
        $id = intval($id);
        $sql = "SELECT p.*, c.name AS category_name, n.name AS manufacturer_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN nhasanxuat n ON p.manufacturer_id = n.id
                WHERE p.id = {$id}";
        
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Add new product
     */
    public function addProduct($data) {
        return $this->insert($data);
    }
    
    /**
     * Update product
     */
    public function updateProduct($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Delete product
     */
    public function deleteProduct($id) {
        $id = intval($id);
        
        // Delete related cart_items first
        $this->conn->query("DELETE FROM cart_items WHERE product_id = {$id}");
        
        // Delete related order_items
        $this->conn->query("DELETE FROM order_items WHERE product_id = {$id}");
        
        // Delete related reviews
        $this->conn->query("DELETE FROM reviews WHERE product_id = {$id}");
        
        // Now delete the product
        return $this->delete($id);
    }
    
    /**
     * Search products
     */
    public function search($keyword, $limit = null) {
        $keyword = $this->conn->real_escape_string($keyword);
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE '%{$keyword}%' OR p.description LIKE '%{$keyword}%'
                ORDER BY p.id DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . intval($limit);
        }
        
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
     * Get products by manufacturer
     */
    public function getByManufacturer($manufacturer_id) {
        $manufacturer_id = intval($manufacturer_id);
        $sql = "SELECT name, price, stock, image
                FROM products
                WHERE manufacturer_id = {$manufacturer_id}
                ORDER BY id DESC";
        
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
}
?>
