<?php
session_start();
include('assets/condb/condb.php');

if (isset($_GET['productId']) && isset($_GET['quantity'])) {
    $productId = $_GET['productId'];
    $quantity = (int)$_GET['quantity'];

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

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            if ($cartItem['product_id'] == $productId) {
                $_SESSION['cart'][$key]['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

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
