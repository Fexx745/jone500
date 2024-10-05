<?php
session_start(); // เริ่มต้นเซสชัน

include('assets/condb/condb.php');

// ตรวจสอบว่ามีการส่ง productId มาหรือไม่
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // ดึงข้อมูลสินค้าโดยใช้ productId
    $sql = "SELECT product_id, product_name, product_detail, price, size, image, stockQty FROM products WHERE product_id = :productId"; // ใช้ product_id
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // เช็คจำนวนในสต็อก
        $stockQty = $product['stockQty']; // ดึงจำนวนสินค้าในสต็อก

        // สร้างอาร์เรย์สินค้าที่จะเก็บในรถเข็น
        $cartItem = [
            'product_id' => $product['product_id'], // ใช้ product_id
            'product_name' => $product['product_name'],
            'product_detail' => $product['product_detail'],
            'price' => $product['price'],
            'size' => $product['size'],
            'image' => $product['image'],
            'quantity' => 1 // กำหนดจำนวนเริ่มต้นเป็น 1
        ];

        // ตรวจสอบว่ามีรถเข็นอยู่แล้วหรือไม่
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // ตรวจสอบว่ามีสินค้านี้อยู่ในรถเข็นแล้วหรือไม่
        $productFound = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $cartItem['product_id']) { // ใช้ product_id
                // ตรวจสอบว่าเพิ่มจำนวนสินค้าจะไม่เกินจำนวนในสต็อก
                if ($item['quantity'] < $stockQty) {
                    $item['quantity'] += 1; // เพิ่มจำนวนสินค้าในรถเข็น
                    $productFound = true;
                } else {
                    echo "<script>alert('จำนวนสินค้าที่คุณต้องการเพิ่มเกินจำนวนในสต็อก'); window.location.href = 'index.php';</script>";
                    exit; // ออกจากสคริปต์
                }
                break;
            }
        }

        // ถ้าไม่พบสินค้าในรถเข็น ให้เพิ่มลงไป
        if (!$productFound) {
            if (1 <= $stockQty) { // ตรวจสอบจำนวนในสต็อกก่อนเพิ่ม
                $_SESSION['cart'][] = $cartItem;
            } else {
                echo "<script>alert('ไม่สามารถเพิ่มสินค้านี้ลงในรถเข็นได้'); window.location.href = 'index.php';</script>";
                exit; // ออกจากสคริปต์
            }
        }

        // แสดงข้อความสำเร็จ
        echo "<script>alert('สินค้าถูกเพิ่มลงในรถเข็นแล้ว!');</script>";
    } else {
        echo "<script>alert('ไม่พบสินค้านี้ในระบบ'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลสินค้า'); window.location.href = 'index.php';</script>";
}

$conn = null;
?>
