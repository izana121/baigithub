<?php
class Controller {
    protected $db;
    protected $conn;
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Load a model
     */
    protected function model($model) {
        $modelFile = __DIR__ . '/../models/' . $model . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        
        return null;
    }
    
    /**
     * Render a view
     */
    protected function view($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Also pass conn for backward compatibility
        $conn = $this->conn;
        
        // Include the view file
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View not found: " . $view;
        }
    }
    
    /**
     * Redirect to another page
     */
    protected function redirect($url) {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        }
        echo '<script>window.location.href = "' . htmlspecialchars($url, ENT_QUOTES) . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url, ENT_QUOTES) . '" /></noscript>';
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Check if user is admin
     */
    protected function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    /**
     * Get current user ID
     */
    protected function getUserId() {
        return isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    }
    
    /**
     * Get current username
     */
    protected function getUsername() {
        return isset($_SESSION['username']) ? $_SESSION['username'] : '';
    }
    
    /**
     * Require login
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php?page=login');
        }
    }
    
    /**
     * Require admin
     */
    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->redirect('index.php?page=home');
        }
    }
    
    /**
     * Get POST data
     */
    protected function post($key, $default = null) {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
    
    /**
     * Get GET data
     */
    protected function get($key, $default = null) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
    
    /**
     * Get REQUEST data
     */
    protected function request($key, $default = null) {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    /**
     * Hàm gọi API
     */
public function callAPI($method, $url, $data = []) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $headers = [];

    switch ($method) {

        case "POST":
            $headers[] = 'Content-Type: application/json';
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $headers[] = 'Content-Type: application/json';
            break;

        case "PUT":
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

            // Gửi JSON cho PUT/DELETE
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $headers[] = 'Content-Type: application/json';
            break;

        case "GET":
            if (!empty($data)) {
                $url .= '?' . http_build_query($data);
            }
            break;
    }

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        return [
            'success' => false,
            'message' => curl_error($curl)
        ];
    }

    curl_close($curl);

    return json_decode($response, true);
}

protected function getJsonInput() {
        static $jsonData = null;

        if ($jsonData === null) {
            $input = trim(file_get_contents('php://input'));
            $jsonData = [];

            if ($input !== '') {
                $decoded = json_decode($input, true);
                if (is_array($decoded)) {
                    $jsonData = $decoded;
                }
            }
        }

        return $jsonData;
    }

protected function requestData($key, $default = null) {
        $json = $this->getJsonInput();
        if (is_array($json) && array_key_exists($key, $json)) {
            return $json[$key];
        }

        return $this->request($key, $default);
    }
    
protected function jsonResponse($data, $status = 200) {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json; charset=utf-8');
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>
