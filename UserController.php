<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * User Controller
 */
class UserController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Login page
     */
    public function login(){
        $error = '';
        $success = '';
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])){
            $username = $this ->post('username');
            $password = $this ->post('password');

            $result = $this ->callAPI(
                "POST",
                "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=login",
                [
                    "username" => $username,
                    "password" => $password
                ]
            );

            if($result && $result['success']){
                $_SESSION['user_id'] = $result['data']['id'];
                $_SESSION['username'] = $result['data']['username'];
                $_SESSION['role'] = $result['data']['role'];

                $this ->redirect('index.php?page=home');
            } else {
                $error = $result['message'] ?? 'Sai tên đăng nhập hoặc mật khẩu.';
            }
        }

        $this ->view('user/login',[
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Register page
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
            } else {
                $result = $this->callAPI(
                        "POST",
                        "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=register",
                        [
                            "username" => $username,
                            "email" => $email,
                            "password" => $password,
                            "confirm_password" => $confirm_password
                        ]
                    );
                
                if ($result && $result['success']) {
                    $this->redirect('index.php?page=login');
                } else {
                    $error = $result['message'] ?? 'Đăng ký thất bại';
                }
            }
        }
        
        $this->view('user/register', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        $this->redirect('index.php?page=home');
    }
    
    /**
     * Profile page
     */
    public function profile() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
     
        $result = $this->callAPI(
    "GET",
    "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=profile&user_id=".$user_id,
    []
);

        if($result && $result['success']){
            $user = $result['data'];
        }  else {
            $user = null;
        }
        
        $this->view('user/profile', [
            'user' => $user
        ]);
    }
    
    /**
     * Edit profile
     */
    public function profileEdit() {
    $this->requireLogin();
    
    $user_id = $this->getUserId();
    
    $error = '';
    $success = '';
    
    // LẤY USER TỪ API
    $result = $this->callAPI(
        "GET",
        "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=profile&user_id=".$user_id
    );

    $user = ($result && $result['success']) ? $result['data'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $this->post('email');
        $phone = $this->post('phone');
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        }

        if (empty($error)) {

            $result = $this->callAPI(
                "PUT",
                "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=edit_profile",
                [
                    'user_id' => $user_id,
                    'email' => $email,
                    'phone' => $phone
                ]
            );

            if ($result && $result['success']) {
                $success = 'Cập nhật thành công';

                $user = $result['data'];
            } else {
                $error = $result['message'] ?? 'Cập nhật thất bại';
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
     * Change password
     */
    public function profilePassword() {
        $this->requireLogin();
        
        $user_id = $this->getUserId();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $this->post('current_password');
            $new_password = $this->post('new_password');
            $confirm_password = $this->post('confirm_password');
            
            if(strlen($new_password) < 8){
                $error = 'Mật khẩu mới phải cso ít nhất 8 ký tự';
            } else if($new_password !== $confirm_password){
                $error = 'Mật khẩu xác nhận không khớp';
            } else {
                
                $result = $this ->callAPI(
                    "PUT",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/User_api.php?action=change_password",
                    [
                        'user_id' => $user_id,
                        'current_password' => $current_password,
                        'new_password' => $new_password
                    ]
                );

                if($result && $result['success']){
                    $success = 'Đổi mật khẩu thành công';
                } else {
                    $error = $result['message'] ?? 'Đổi mật khẩu thất bại';
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
