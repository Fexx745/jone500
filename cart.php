<?php
session_start(); // เริ่มต้นเซสชัน

// ตรวจสอบว่ามีรถเข็นอยู่ใน Session หรือไม่
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// เพิ่มสินค้าลงในรถเข็น
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];
    // ตรวจสอบว่ามีสินค้านั้นในรถเข็นหรือไม่
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1; // เพิ่มสินค้าลงในรถเข็น
    } else {
        $_SESSION['cart'][$productId]++; // เพิ่มจำนวนสินค้าที่มีอยู่แล้ว
    }
}

// คำนวณราคาสินค้าทั้งหมด
$totalPrice = 0;
$items = [];

if (!empty($_SESSION['cart'])) {
    include('assets/condb/condb.php');

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $ids = implode(',', array_keys($_SESSION['cart']));

    // ตรวจสอบให้แน่ใจว่า $ids ไม่ว่าง
    if (!empty($ids)) {
        $sql = "SELECT * FROM products WHERE product_id IN ($ids)";
        $result = $conn->query($sql);
        
        if ($result) {
            $products = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                $itemId = $product['product_id']; // ใช้ product_id
                $itemName = $product['product_name'];
                $itemPrice = $product['price'];
                $itemQuantity = $_SESSION['cart'][$itemId];
                $itemTotal = $itemPrice * $itemQuantity;

                $totalPrice += $itemTotal;

                $items[] = [
                    'id' => $itemId,
                    'name' => $itemName,
                    'price' => $itemPrice,
                    'quantity' => $itemQuantity,
                    'total' => $itemTotal
                ];
            }
        } else {
            echo "ไม่สามารถดึงข้อมูลสินค้าได้: " . implode(", ", $conn->errorInfo());
        }
    } else {
        echo "ไม่มีสินค้าในรถเข็น";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Shopping Cart</h2>
    <?php if (empty($items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= htmlspecialchars($item['price']); ?> $</td>
                        <td><?= htmlspecialchars($item['quantity']); ?></td>
                        <td><?= htmlspecialchars($item['total']); ?> $</td>
                        <td>
                            <a href="removeFromCart.php?productId=<?= $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Price:</strong></td>
                    <td colspan="2"><strong><?= htmlspecialchars($totalPrice); ?> $</strong></td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    <?php endif; ?>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
