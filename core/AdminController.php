<?php
require_once __DIR__ . '/Controller.php';

class AdminController extends Controller{
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();

        }
        if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
            header("Location: index.php?page=home");
            exit();
        }
    }
    
}
?>
