<?php

include('assets/condb/condb.php');

// ตรวจสอบว่ามีการส่ง productId มาหรือไม่
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // ดึงข้อมูลสินค้าโดยใช้ productId
    $sql = "SELECT * FROM products WHERE product_id = :productId"; // ใช้ product_id
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // ดึงข้อมูลสินค้าสำเร็จ
        $productName = $product['product_name'];
        $productDetail = $product['product_detail'];
        $price = $product['price'];
        $image = $product['image'];
        $size = $product['size'];
        $stockQty = $product['stockQty'];
    } else {
        echo "<script>alert('ไม่พบสินค้านี้ในระบบ'); window.location.href = 'index.php';</script>";
        exit; // ออกจากสคริปต์
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลสินค้า'); window.location.href = 'index.php';</script>";
    exit; // ออกจากสคริปต์
}

$conn = null; // ปิดการเชื่อมต่อกับฐานข้อมูล
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productName; ?> - Product Detail</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Update this path accordingly -->
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="mt-5"><?= $productName; ?></h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="assets/imge/product/<?= $image; ?>" class="img-fluid" alt="<?= $productName; ?>">
            </div>
            <div class="col-md-6">
                <h5>รายละเอียดสินค้า</h5>
                <p><?= $productDetail; ?></p>
                <p><strong>ราคา:</strong> <?= $price; ?> $</p>
                <p><strong>ขนาด:</strong> <?= $size; ?></p>
                <p><strong>จำนวนในสต็อก:</strong> <?= $stockQty; ?></p>
                <form action="addToCart.php" method="get">
                    <input type="hidden" name="productId" value="<?= $product['product_id']; ?>">
                    <button type="submit" class="btn btn-primary">สั่งซื้อ</button>
                </form>
            </div>
        </div>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
</body>

</html>