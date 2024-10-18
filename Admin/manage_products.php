<?php
include('../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// กำหนดค่าพารามิเตอร์สำหรับการแบ่งหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$number_of_pages = 1; // กำหนดค่าเริ่มต้น หรือคำนวณจากจำนวนข้อมูล

// ดึงข้อมูลจากตาราง products พร้อมกับ category_name จาก categories
try {
    $sql = "SELECT p.product_id, p.product_name, p.product_detail, p.price, p.stockQty, p.size, p.image, p.created_at, c.category_name 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

$search_value = isset($_POST['search_value']) ? $_POST['search_value'] : ''; // กำหนดค่าเริ่มต้น
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'Navbar_Admin.php'; ?>

        <?php include 'Menubar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">จัดการสินค้า</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <form method="post" class="form-inline me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="ค้นหาสินค้า" name="search_value" value="<?php echo htmlspecialchars($search_value); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addProductModal"><i class="fas fa-plus"></i> เพิ่มสินค้า</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>รหัสสินค้า</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>รายละเอียดสินค้า</th>
                                                <th>ราคา</th>
                                                <th>จำนวนสินค้า</th>
                                                <th>ขนาด</th>
                                                <th>รูปภาพ</th>
                                                <th>หมวดหมู่</th>
                                                <th>วันที่สร้าง</th>
                                                <th>การจัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['product_detail']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['stockQty']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['size']); ?></td>
                                                    <td>
                                                        <img src="../assets/imge/product/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" width="50">
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))); ?></td>
                                                    <td>
                                                        <a href='../Admin/Edit/edit_product.php?product_id=<?php echo $row['product_id']; ?>' class='btn btn-warning'><i class="fas fa-edit"></i></a>
                                                        <a href='../Admin/Delete/delete_product.php?product_id=<?php echo $row['product_id']; ?>' class='btn btn-danger' onclick="return confirm('ยืนยันการลบข้อมูล?')"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php if ($page > 1) { ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search_value=<?php echo htmlspecialchars($search_value); ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php for ($i = 1; $i <= $number_of_pages; $i++) { ?>
                                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                                    <a class="page-link" href="?page=<?php echo $i; ?>&search_value=<?php echo htmlspecialchars($search_value); ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($page < $number_of_pages) { ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search_value=<?php echo htmlspecialchars($search_value); ?>" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal สำหรับเพิ่มสินค้า -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">เพิ่มสินค้า</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../Admin/Add/add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="product_name">ชื่อสินค้า</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_detail">รายละเอียดสินค้า</label>
                                <textarea class="form-control" id="product_detail" name="product_detail" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">ราคา</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="stockQty">จำนวนสินค้า</label>
                                <input type="number" class="form-control" id="stockQty" name="stockQty" required>
                            </div>
                            <div class="form-group">
                                <label for="size">ขนาด</label>
                                <input type="text" class="form-control" id="size" name="size" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">หมวดหมู่</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <?php
                                    // ดึงข้อมูลหมวดหมู่เพื่อแสดงใน select
                                    try {
                                        $sql = "SELECT category_id, category_name FROM categories";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($categories as $category) {
                                            echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">รูปภาพ</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- AdminLTE JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>