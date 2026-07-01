<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Trang - Các trang tĩnh
 */
class PageController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Trang giới thiệu
     */
    public function aboutUs() {
        $this->view('page/about_us');
    }
    
    /**
     * Trang liên hệ
     */
    public function contact() {
        $this->view('page/contact');
    }
}
?>
