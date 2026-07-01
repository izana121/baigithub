<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Người dùng
 */
class UserController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Trang đăng nhập
     */
    public function login() {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = $this->post('username');
            $password = $this->post('password');
            
            $user = $this->userModel->verifyLogin($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                $this->redirect('index.php?page=home');
            } else {
                $error = 'Sai tên đăng nhập hoặc mật khẩu.';
            }
        }
        
        $this->view('user/login', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Trang đăng ký
     */
    public function register() {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            $username = $this->post('reg_username');
            $email = $this->post('reg_email');
            $password = $this->post('reg_password');
            $confirm_password = $this->post('reg_confirm_password');
            
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $error = 'Không dùng ký tự đặc biệt trong tên.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif (strlen($password) < 8) {
                $error = 'Mật khẩu phải có ít nhất 8 ký tự.';
            } elseif ($password !== $confirm_password) {
                $error = 'Mật khẩu xác nhận không khớp.';
            } elseif ($this->userModel->exists($username, $email)) {
                $error = 'Tên đăng nhập hoặc email đã tồn tại.';
            } else {
                $result = $this->userModel->register($username, $email, $password);
                
                if ($result) {
                    $this->redirect('index.php?page=login');
                } else {
                    $error = 'Đăng ký thất bại: ' . $this->userModel->getError();
                }
            }
        }
        
        $this->view('user/register', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Đăng xuất
     */
    public function logout() {
        session_destroy();
        $this->redirect('index.php?page=home');
    }
    
    /**
     * Trang hồ sơ cá nhân
     */
    public function profile() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        $user = $this->userModel->findById($user_id);
        
        $this->view('user/profile', [
            'user' => $user
        ]);
    }
    
    /**
     * Chỉnh sửa hồ sơ
     */
    public function profileEdit() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        $user = $this->userModel->findById($user_id);
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->post('email');
            $phone = $this->post('phone');
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ';
            }
            
            if (empty($error)) {
                $result = $this->userModel->updateProfile($user_id, [
                    'email' => $email,
                    'phone' => $phone
                ]);
                
                if ($result) {
                    $success = 'Cập nhật thành công';
                    $user = $this->userModel->findById($user_id);
                } else {
                    $error = 'Cập nhật thất bại';
                }
            }
        }
        
        $this->view('user/profile_edit', [
            'user' => $user,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Đổi mật khẩu
     */
    public function profilePassword() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        $user = $this->userModel->findById($user_id);
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $this->post('current_password');
            $new_password = $this->post('new_password');
            $confirm_password = $this->post('confirm_password');
            
            if ($current_password !== $user['password']) {
                $error = 'Mật khẩu hiện tại không đúng';
            } elseif (strlen($new_password) < 8) {
                $error = 'Mật khẩu mới phải có ít nhất 8 ký tự';
            } elseif ($new_password !== $confirm_password) {
                $error = 'Mật khẩu mới không khớp';
            } else {
                $result = $this->userModel->updateProfile($user_id, [
                    'password' => $new_password
                ]);
                
                if ($result) {
                    $success = 'Đổi mật khẩu thành công';
                } else {
                    $error = 'Đổi mật khẩu thất bại';
                }
            }
        }
        
        $this->view('user/profile_password', [
            'error' => $error,
            'success' => $success
        ]);
    }
}
?>
