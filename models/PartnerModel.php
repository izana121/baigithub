<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Đối tác (Nhà sản xuất)
 */
class PartnerModel extends Model {
    protected $table = 'nhasanxuat';
    
    /**
     * Lấy tất cả đối tác
     */
    public function getAllPartners() {
        return $this->findAll('id DESC');
    }
    
    /**
     * Lấy đối tác theo ID
     */
    public function getPartner($id) {
        return $this->findById($id);
    }
    
    /**
     * Thêm đối tác
     */
    public function addPartner($name, $description = '') {
        return $this->insert([
            'name' => $name,
            'description' => $description
        ]);
    }
    
    /**
     * Cập nhật đối tác
     */
    public function updatePartner($id, $name, $description = '') {
        return $this->update($id, [
            'name' => $name,
            'description' => $description
        ]);
    }
    
    /**
     * Xóa đối tác
     */
    public function deletePartner($id) {
        $id = intval($id);
        
        // Đặt manufacturer_id thành NULL cho tất cả sản phẩm của đối tác này
        // (hoặc có thể xóa sản phẩm nếu muốn)
        $this->conn->query("UPDATE products SET manufacturer_id = NULL WHERE manufacturer_id = {$id}");
        
        // Cuối cùng xóa đối tác
        return $this->delete($id);
    }
}
?>
