<?php
session_start();
include('assets/condb/condb.php'); // รวมไฟล์การเชื่อมต่อฐานข้อมูล

if (isset($_GET['productId']) && isset($_GET['action'])) {
    $productId = $_GET['productId'];
    $action = $_GET['action'];

    // ดึง stockQty จากฐานข้อมูล
    $stmt = $conn->prepare("SELECT stockQty FROM products WHERE product_id = :productId");
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $stockQty = $product['stockQty'];

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['product_id'] == $productId) {
                    if ($action == 'remove') {
                        unset($_SESSION['cart'][$key]);
                    } elseif ($action == 'increase') {
                        if ($item['quantity'] < $stockQty) { // ตรวจสอบสต็อกก่อนเพิ่ม
                            $_SESSION['cart'][$key]['quantity'] += 1;
                        } else {
                            echo "<script>alert('จำนวนสินค้าที่มีอยู่ไม่เพียงพอ');</script>";
                        }
                    } elseif ($action == 'decrease') {
                        if ($_SESSION['cart'][$key]['quantity'] > 1) {
                            $_SESSION['cart'][$key]['quantity'] -= 1;
                        } else {
                            unset($_SESSION['cart'][$key]);
                        }
                    }
                    break;
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    } else {
        echo "<script>alert('ไม่พบสินค้านี้ในระบบ');</script>";
    }
}

header("Location: cart.php");
exit;
