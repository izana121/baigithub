<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Tin tức
 */
class NewsController extends Controller {
    private $newsModel;
    
    public function __construct() {
        parent::__construct();
        $this->newsModel = $this->model('NewsModel');
    }
    
    /**
     * Danh sách tin tức
     */
    public function index() {
        $deleteMessage = '';
        
        // Xử lý xóa
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->post('delete_id')) {
            $deleteId = intval($this->post('delete_id'));
            
            if ($this->isAdmin() || $this->getUsername() === 'test') {
                if ($this->newsModel->deleteNews($deleteId)) {
                    $deleteMessage = '✅ Đã xóa tin tức thành công.';
                } else {
                    $deleteMessage = '❌ Xóa thất bại. Vui lòng thử lại.';
                }
            } else {
                $deleteMessage = '⚠️ Bạn không có quyền xóa tin tức.';
            }
        }
        
        $news = $this->newsModel->getAllNews();
        
        $this->view('news/index', [
            'news' => $news,
            'deleteMessage' => $deleteMessage
        ]);
    }
    
    /**
     * Thêm tin tức
     */
    public function add() {
        // Cho phép admin hoặc user test
        if (!$this->isAdmin() && $this->getUsername() !== 'test') {
            echo 'Bạn không thể đăng tin.';
            exit;
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($this->post('title', ''));
            $content = trim($this->post('content', ''));
            $author_id = $this->getUserId();
            
            // Xử lý upload ảnh
            $imageName = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $imageName;
                
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $error = 'Lỗi khi tải ảnh lên.';
                }
            }
            
            if (empty($error) && !empty($title) && !empty($content)) {
                $result = $this->newsModel->addNews($title, $content, $imageName, $author_id);
                
                if ($result) {
                    $success = 'Đăng tin thành công';
                } else {
                    $error = 'Lỗi khi lưu tin';
                }
            }
        }
        
        $this->view('news/add', [
            'error' => $error,
            'success' => $success
        ]);
    }
}
?>
