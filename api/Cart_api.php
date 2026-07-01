<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Api.php';
require_once __DIR__ . '/../models/CartModel.php';

class CartApi extends Api {
    private $cartModel;

    public function __construct() {
        parent::__construct();
        $this->cartModel = new CartModel();
    }

    public function handleRequest() {
        $action = $this->getParam('action');

        switch ($action) {
        	echo "hello world";
            case 'list':
                $user_id = $this->getParam('user_id', 0);
                $cart_id = $this->cartModel->getOrCreateCart($user_id);
                $items = $this->cartModel->getItems($cart_id);
                $this->response(true, $items);
                break;

            case 'add':
                $user_id = $this->input['user_id'] ?? 0;
                $product_id = $this->input['product_id'] ?? 0;
                $quantity = $this->input['quantity'] ?? 1;
                $cart_id = $this->cartModel->getOrCreateCart($user_id);
                $success = $this->cartModel->addItem($cart_id, $product_id, $quantity);
                $this->response($success, [], $success ? "Đã thêm" : "Lỗi");
                break;

            case 'update':
                $id = $this->input['cart_item_id'] ?? 0;
                $quantity = $this->input['quantity'] ?? 0;
                if ($id > 0 && $quantity > 0) {
                    $success = $this->cartModel->updateQuantity($id, $quantity);
                    $this->response($success, [], $success ? "Cập nhật thành công" : "Lỗi");
                } else {
                    $this->response(false, [], "Dữ liệu không hợp lệ");
                }
                break;

            case 'remove':
                $id = $this->input['cart_item_id'] ?? 0;
                $success = $this->cartModel->removeItem($id);
                $this->response($success, [], $success ? "Đã xóa" : "Lỗi");
                break;

            default:
                $this->response(false, [], "Hành động không hợp lệ");
                break;
        }
    }
} 

$api = new CartApi();
$api->handleRequest();
