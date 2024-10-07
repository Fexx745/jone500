<?php
session_start();
include('assets/condb/condb.php');

// ตรวจสอบว่ามีการส่ง productId และ quantity มาหรือไม่
if (isset($_GET['productId']) && isset($_GET['quantity'])) {
    $productId = $_GET['productId'];
    $quantity = (int)$_GET['quantity'];

    // ดึงข้อมูลสินค้าโดยใช้ productId
    $sql = "SELECT * FROM products WHERE product_id = :productId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $item = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['image']
        ];

        // ตรวจสอบว่า session ตะกร้าสินค้าถูกสร้างหรือยัง ถ้ายังก็สร้าง
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // ตรวจสอบว่ามีสินค้านี้อยู่ในตะกร้าแล้วหรือไม่
        $found = false;
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            if ($cartItem['product_id'] == $productId) {
                // ถ้ามีสินค้าอยู่แล้ว เพิ่มจำนวน
                $_SESSION['cart'][$key]['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // ถ้าไม่มีสินค้าในตะกร้า ก็เพิ่มใหม่
        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        echo "<script>window.location.href = 'cart.php';</script>";
    } else {
        echo "<script>alert('ไม่พบสินค้านี้ในระบบ'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('ข้อมูลไม่ครบถ้วน'); window.location.href = 'index.php';</script>";
}
?>
