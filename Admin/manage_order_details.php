<?php
include('../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// กำหนดค่าพารามิเตอร์สำหรับการแบ่งหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$number_of_pages = 1; // กำหนดค่าเริ่มต้น หรือคำนวณจากจำนวนข้อมูล

// ดึงข้อมูลจากตาราง tb_order_details โดยเชื่อมโยงกับ tb_orders และ tb_products
try {
    $sql = "SELECT od.order_detail_id, od.order_id, od.product_id, od.quantity, od.price, o.order_date, o.order_status 
            FROM tb_order_details od 
            JOIN tb_orders o ON od.order_id = o.order_id 
            JOIN products p ON od.product_id = p.product_id";
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
    <title>จัดการรายละเอียดคำสั่งซื้อ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'Navbar_Admin.php'; ?>

        <?php include 'Menubar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">จัดการรายละเอียดคำสั่งซื้อ</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <form method="post" class="form-inline me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="ค้นหารายละเอียดคำสั่งซื้อ" name="search_value" value="<?php echo htmlspecialchars($search_value); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addOrderDetailModal"><i class="fas fa-plus"></i> เพิ่มรายละเอียดคำสั่งซื้อ</button>
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
                                                <th>รหัสรายละเอียดคำสั่งซื้อ</th>
                                                <th>รหัสคำสั่งซื้อ</th>
                                                <th>รหัสสินค้า</th>
                                                <th>จำนวน</th>
                                                <th>ราคา</th>
                                                <th>วันที่สั่งซื้อ</th>
                                                <th>สถานะคำสั่งซื้อ</th>
                                                <th>การจัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['order_detail_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['order_date']))); ?></td>
                                                    <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                                                    <td>
                                                        <a href='../Admin/Edit/edit_order_detail.php?order_detail_id=<?php echo $row['order_detail_id']; ?>' class='btn btn-warning'><i class="fas fa-edit"></i></a>
                                                        <a href='../Admin/Delete/delete_order_detail.php?order_detail_id=<?php echo $row['order_detail_id']; ?>' class='btn btn-danger' onclick="return confirm('ยืนยันการลบข้อมูล?')"><i class="fas fa-trash"></i></a>
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

        <!-- Modal สำหรับเพิ่มรายละเอียดคำสั่งซื้อ -->
        <div class="modal fade" id="addOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="addOrderDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderDetailModalLabel">เพิ่มรายละเอียดคำสั่งซื้อ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../Admin/Add/add_order_detail.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="order_id">รหัสคำสั่งซื้อ</label>
                                <input type="text" class="form-control" id="order_id" name="order_id" required>
                            </div>
                            <div class="form-group">
                                <label for="product_id">รหัสสินค้า</label>
                                <input type="text" class="form-control" id="product_id" name="product_id" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">จำนวน</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="price">ราคา</label>
                                <input type="number" class="form-control" id="price" name="price" required>
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