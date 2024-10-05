<?php

$host = 'localhost'; // ชื่อโฮสต์
$dbname = 'clothing_store_db'; // ชื่อฐานข้อมูล
$username = 'root'; // ชื่อผู้ใช้ MySQL
$password = ''; // รหัสผ่าน MySQL

try {
    // สร้างการเชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // ตั้งค่า PDO error mode ให้แสดงเป็น exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // แสดงข้อความเมื่อการเชื่อมต่อล้มเหลว
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
