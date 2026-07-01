<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Partner (Nha San Xuat) Model
 */
class PartnerModel extends Model {
    protected $table = 'nhasanxuat';
    
    /**
     * Get all partners
     */
    public function getAllPartners() {
        return $this->findAll('id DESC');
    }
    
    /**
     * Get partner by ID
     */
    public function getPartner($id) {
        return $this->findById($id);
    }
    
    /**
     * Add partner
     */
    public function addPartner($name, $description = '') {
        return $this->insert([
            'name' => $name,
            'description' => $description
        ]);
    }
    
    /**
     * Update partner
     */
    public function updatePartner($id, $name, $description = '') {
        return $this->update($id, [
            'name' => $name,
            'description' => $description
        ]);
    }
    
    /**
     * Delete partner
     */
    public function deletePartner($id) {
        $id = intval($id);
        
        // Set manufacturer_id to NULL for all products of this partner
        // (or you could delete the products if preferred)
        $this->conn->query("UPDATE products SET manufacturer_id = NULL WHERE manufacturer_id = {$id}");
        
        // Now delete the partner
        return $this->delete($id);
    }
}
?>
