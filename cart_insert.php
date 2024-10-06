<?php
session_start();
include('assets/condb/condb.php');

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 && isset($_POST['totalPrice'])) {
    $totalPrice = $_POST['totalPrice'];

    if (!isset($_SESSION['customer_id'])) {
        echo "กรุณาเข้าสู่ระบบก่อนทำการสั่งซื้อ";
        exit();
    }

    try {
        $conn->beginTransaction();

        // Insert order with initial payment status set to 0 (pending)
        $sqlOrder = "INSERT INTO tb_orders (customer_id, total_price, order_date, order_status) 
                     VALUES (:customerId, :totalPrice, NOW(), 0)";
        $stmtOrder = $conn->prepare($sqlOrder);
        $customerId = $_SESSION['customer_id']; // Use customer_id from session
        $stmtOrder->bindParam(':customerId', $customerId);
        $stmtOrder->bindParam(':totalPrice', $totalPrice);
        $stmtOrder->execute();

        $orderId = $conn->lastInsertId();

        // Prepare insert for order details
        $sqlOrderDetails = "INSERT INTO tb_order_details (order_id, product_id, quantity, price) 
                            VALUES (:orderId, :productId, :quantity, :price)";
        $stmtOrderDetails = $conn->prepare($sqlOrderDetails);

        foreach ($_SESSION['cart'] as $item) {
            $stmtOrderDetails->bindParam(':orderId', $orderId);
            $stmtOrderDetails->bindParam(':productId', $item['product_id']);
            $stmtOrderDetails->bindParam(':quantity', $item['quantity']);
            $stmtOrderDetails->bindParam(':price', $item['price']);
            $stmtOrderDetails->execute();
        }

        $conn->commit();

        unset($_SESSION['cart']);

        header("Location: cart_history.php");
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo "การสั่งซื้อไม่สำเร็จ: " . $e->getMessage();
    }
} else {
    echo "ตะกร้าสินค้าว่างหรือไม่มีข้อมูลราคา";
}
?>
