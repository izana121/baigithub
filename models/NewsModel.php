<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Model Tin tức
 */
class NewsModel extends Model {
    protected $table = 'news';
    
    /**
     * Lấy tất cả tin tức với tác giả
     */
    public function getAllNews() {
        $sql = "SELECT n.*, u.username AS author_name 
                FROM news n 
                LEFT JOIN users u ON n.author_id = u.id 
                ORDER BY n.created_at DESC";
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
     * Lấy tin tức theo ID
     */
    public function getNews($id) {
        $id = intval($id);
        $sql = "SELECT n.*, u.username AS author_name 
                FROM news n 
                LEFT JOIN users u ON n.author_id = u.id 
                WHERE n.id = {$id}";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    /**
     * Thêm tin tức
     */
    public function addNews($title, $content, $image, $authorId) {
        return $this->insert([
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'author_id' => $authorId
        ]);
    }
    
    /**
     * Cập nhật tin tức
     */
    public function updateNews($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Xóa tin tức
     */
    public function deleteNews($id) {
        return $this->delete($id);
    }
}
?>
