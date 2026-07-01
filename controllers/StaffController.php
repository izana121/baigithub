<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Bộ điều khiển Nhân viên
 */
class StaffController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Quản lý nhân viên (Admin)
     */
    public function admin() {
        $this->requireAdmin();
        
        $staff = $this->userModel->getStaff();
        
        $this->view('staff/admin', [
            'staff' => $staff
        ]);
    }
    
    /**
     * Thêm nhân viên
     */
    public function add() {
        $this->requireAdmin();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->post('username');
            $email = $this->post('email');
            $password = $this->post('password');
            
            if (empty($username) || empty($email) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ thông tin';
            } elseif ($this->userModel->exists($username, $email)) {
                $error = 'Tên đăng nhập hoặc email đã tồn tại';
            } else {
                $result = $this->userModel->register($username, $email, $password, 'admin');
                
                if ($result) {
                    $this->redirect('index.php?page=admin_staff');
                } else {
                    $error = 'Thêm nhân viên thất bại';
                }
            }
        }
        
        $this->view('staff/add', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Chỉnh sửa nhân viên
     */
    public function edit() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);
        $staff = $this->userModel->findById($id);
        
        if (!$staff) {
            $this->redirect('index.php?page=admin_staff');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->post('email');
            $phone = $this->post('phone', '');
            $password = $this->post('password');
            
            $data = [
                'email' => $email,
                'phone' => $phone
            ];
            
            if (!empty($password)) {
                $data['password'] = $password;
            }
            
            $result = $this->userModel->updateProfile($id, $data);
            
            if ($result) {
                $success = 'Cập nhật thành công';
                $staff = $this->userModel->findById($id);
            } else {
                $error = 'Cập nhật thất bại';
            }
        }
        
        $this->view('staff/edit', [
            'staff' => $staff,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Xóa nhân viên
     */
    public function delete() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);
        $user = $this->userModel->findById($id);
        
        // Không thể xóa chính mình
        if ($id == $this->getUserId()) {
            echo '<script>alert("Không thể xóa chính mình!"); history.back();</script>';
            exit;
        }
        
        if (!$user) {
            echo '<script>alert("Không tìm thấy người dùng!"); history.back();</script>';
            exit;
        }
        
        // Nếu đã xác nhận, xóa người dùng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->post('confirm')) {
            $result = $this->userModel->deleteUser($id);
            if ($result) {
                echo '<script>alert("Xóa người dùng thành công!"); window.location.href="index.php?page=admin_staff";</script>';
            } else {
                echo '<script>alert("Xóa người dùng thất bại!"); history.back();</script>';
            }
            exit;
        }
        
        // Hiển thị trang xác nhận
        $this->view('staff/delete', [
            'user' => $user
        ]);
    }
}
?>
