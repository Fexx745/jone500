<?php
session_start();
include('assets/condb/condb.php');

// รับหมวดหมู่จาก URL (หากมี)
$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Query ดึงรายการสินค้าตามหมวดหมู่ (ถ้ามีการเลือกหมวดหมู่)
$sql = "SELECT * FROM products";
if ($categoryId) {
    $sql .= " WHERE category_id = :categoryId";
}
$stmt = $conn->prepare($sql);

if ($categoryId) {
    $stmt->bindParam(':categoryId', $categoryId);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หมวดหมู่สินค้า</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- ลิงก์ Bootstrap -->
</head>
<body>
    <?php include('navbar.php'); ?> <!-- Include ไฟล์ navbar -->

    <div class="container mt-5">
        <h1>หมวดหมู่สินค้า</h1>

        <!-- แสดงรายการสินค้า -->
        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="assets/imge/product/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['product_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p class="card-text">ราคา: <?php echo number_format($product['price'], 2); ?> บาท</p>
                                <a href="product_detail.php?productId=<?php echo $product['product_id']; ?>" class="btn btn-primary">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>ไม่มีสินค้าสำหรับหมวดหมู่นี้</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="path/to/jquery.min.js"></script> <!-- ลิงก์ jQuery -->
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- ลิงก์ Bootstrap JavaScript -->
</body>
</html>
