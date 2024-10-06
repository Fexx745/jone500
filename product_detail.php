<?php

include('assets/condb/condb.php');

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    $sql = "SELECT * FROM products WHERE product_id = :productId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $productName = $product['product_name'];
        $productDetail = $product['product_detail'];
        $price = $product['price'];
        $image = $product['image'];
        $size = $product['size'];
        $stockQty = $product['stockQty'];
    } else {
        echo "<script>alert('ไม่พบสินค้านี้ในระบบ'); window.location.href = 'index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ไม่พบข้อมูลสินค้า'); window.location.href = 'index.php';</script>";
    exit;
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $productName; ?> - Product Detail</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
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
                <a href="addToCart.php?productId=<?= $productId ?>&quantity=1" class="btn btn-primary">สั่งซื้อ</a>
            </div>
        </div>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script>
</body>

</html>