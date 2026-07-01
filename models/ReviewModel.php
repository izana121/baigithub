<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Đánh giá
 */
class ReviewModel extends Model {
    protected $table = 'reviews';
    
    /**
     * Lấy đánh giá theo sản phẩm
     */
    public function getByProduct($productId) {
        $productId = intval($productId);
        $sql = "SELECT * FROM reviews WHERE product_id = {$productId} ORDER BY id DESC";
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
     * Thêm đánh giá
     */
    public function addReview($userId, $username, $productId, $rating, $comment) {
        return $this->insert([
            'user_id' => $userId,
            'username' => $username,
            'product_id' => $productId,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }
    
    /**
     * Xóa đánh giá
     */
    public function deleteReview($id) {
        return $this->delete($id);
    }
    
    /**
     * Lấy điểm đánh giá trung bình cho sản phẩm
     */
    public function getAverageRating($productId) {
        $productId = intval($productId);
        $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE product_id = {$productId}";
        $result = $this->conn->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return round($row['avg_rating'], 1);
        }
        
        return 0;
    }
}
?>
