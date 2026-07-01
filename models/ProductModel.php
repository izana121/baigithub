<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Sản phẩm
 */
class ProductModel extends Model {
    protected $table = 'products';
    
    /**
     * Lấy sản phẩm với tên danh mục
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
     * Lấy sản phẩm theo danh mục
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
     * Tìm kiếm sản phẩm
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
     * Đếm kết quả tìm kiếm
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
     * Lấy chi tiết sản phẩm với nhà sản xuất
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
     * Thêm sản phẩm mới
     */
    public function addProduct($data) {
        return $this->insert($data);
    }
    
    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($id) {
        $id = intval($id);
        
        // Xóa cart_items liên quan trước
        $this->conn->query("DELETE FROM cart_items WHERE product_id = {$id}");
        
        // Xóa order_items liên quan
        $this->conn->query("DELETE FROM order_items WHERE product_id = {$id}");
        
        // Xóa đánh giá liên quan
        $this->conn->query("DELETE FROM reviews WHERE product_id = {$id}");
        
        // Cuối cùng xóa sản phẩm
        return $this->delete($id);
    }
    
    /**
     * Tìm kiếm sản phẩm (phương thức cũ)
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
     * Lấy sản phẩm theo nhà sản xuất
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
