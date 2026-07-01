<?php
/**
 * Lớp Api cơ sở
 */
require_once __DIR__ . '/Database.php';
class Api {
    protected $db;
    protected $conn;
    protected $input;

    public function __construct() {
       
        header('Content-Type: application/json');

        
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();

       
        $this->input = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    
    protected function response($success = true, $data = [], $message = "") {
        echo json_encode([
            'success' => $success,
            'data' => $data,
            'message' => $message
        ]);
        exit;
    }

   
    protected function getParam($key, $default = '') {
        return $_GET[$key] ?? $default;
    }
}
