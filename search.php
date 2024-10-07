<?php
session_start();
include('assets/condb/condb.php');

$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

if ($searchTerm) {
    $sql = "SELECT * FROM products WHERE product_name LIKE :searchTerm";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลการค้นหา</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- ลิงก์ Bootstrap -->
</head>
<body>
    <?php include('navbar.php'); ?> <!-- Include ไฟล์ navbar -->

    <div class="container mt-5">
        <h1>ผลการค้นหาสินค้า: "<?php echo htmlspecialchars($searchTerm); ?>"</h1>

        <!-- แสดงรายการผลการค้นหา -->
        <div class="row">
            <?php if (!empty($searchResults)) : ?>
                <?php foreach ($searchResults as $product) : ?>
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
            <?php else : ?>
                <div class="col-12">
                    <p>ไม่พบสินค้าที่ตรงกับคำค้นหา</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="path/to/jquery.min.js"></script> <!-- ลิงก์ jQuery -->
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- ลิงก์ Bootstrap JavaScript -->
</body>
</html>
