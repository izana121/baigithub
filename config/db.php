<?php


$conn = new mysqli("localhost", "root", "", "nhom") or die ("Khong the ket noi CSDL");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
