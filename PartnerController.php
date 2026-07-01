<?php
require_once __DIR__ . '/../core/Controller.php';

/**
 * Partner Controller
 */
class PartnerController extends Controller {
    private $partnerModel;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Admin partners list
     */
    public function admin() {
        $this->requireAdmin();
        
      $res = $this ->callAPI(
            "GET",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php"
      );

      $partners = ($res && $res['success']) ? $res['data'] : [];
        
        $this->view('partner/admin', [
            'partners' => $partners
        ]);
    }
    
    /**
     * Add partner
     */
    public function add() {
        $this->requireAdmin();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            $description = $this->post('description', '');
            
            if (!empty($name)) {
                $result = $this->callAPI(
                    "POST",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php",
                    [
                        'name' => $name,
                        'description' => $description
                    ]
                );
                
                if ($result && $result['success']) {
                    $this->redirect('index.php?page=admin_partners');
                } else {
                    $error = 'Thêm đối tác thất bại';
                }
            } else {
                $error = 'Tên đối tác không được để trống';
            }
        }
        
        $this->view('partner/add', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Edit partner
     */
    public function edit() {
        $this->requireAdmin();
        
        $id = $this->get('id', 0);
        $res = $this->callAPI(  
            "GET",
            "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php?id=".$id
        );

        $partner = ($res && $res['success']) ? $res['data'] : null;
        
        if (!$partner) {
            $this->redirect('index.php?page=admin_partners');
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->post('name');
            $description = $this->post('description', '');
            
            if (!empty($name)) {
               $result = $this->callAPI(
                    "PUT",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php",
                    [
                        'id' => $id,
                        'name' => $name,
                        'description' => $description
                    ]
                );
                
                 if ($result && $result['success']) {
                    $success = 'Cập nhật thành công';
                    $partner['name'] = $name;
                    $partner['description'] = $description;
                } else {
                    $error = 'Cập nhật thất bại';
                }
            } else {
                $error = 'Tên đối tác không được để trống';
            }
        }
        
        $this->view('partner/edit', [
            'partner' => $partner,
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Delete partner
     */
        public function delete(){
            $this -> requireAdmin();

            $id = $this->get('id', 0);

            if($id > 0){
                $this ->callAPI(
                    "DELETE",
                    "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php",
                    ['id' => $id]
                );
                
            }

            $this ->redirect('index.php?page=admin_partners');
        }
    
    /**
     * Partner detail
     */
    public function detail() {
    $this->requireAdmin();
    
    $id = $this->get('id', 0);

    $res = $this->callAPI(
        "GET",
        "http://localhost/NHOM8-WEB/ChoXanh-main/api/partner_api.php?id=".$id
    );

    $partner = ($res && $res['success']) ? $res['data'] : null;

    // Fix trường hợp array[0]
    if (is_array($partner) && isset($partner[0])) {
        $partner = $partner[0];
    }

    
    if (!$partner) {
        echo '<h3>Không có dữ liệu partner</h3>';
        var_dump($res); // debug luôn
        die();
    }

    $productRes = $this->callAPI(
        "GET",
        "http://localhost/NHOM8-WEB/ChoXanh-main/api/product_api.php?action=by_manufacturer&manufacturer_id=".$id
    );

    $products = ($productRes && $productRes['success']) ? $productRes['data'] : [];
    $this->view('partner/detail', [
        'partner' => $partner,
        'products' => $products
    ]);
}
}
?>
