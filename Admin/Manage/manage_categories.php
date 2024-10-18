<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// กำหนดค่าพารามิเตอร์สำหรับการแบ่งหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$number_of_pages = 1; // กำหนดค่าเริ่มต้น หรือคำนวณจากจำนวนข้อมูล

// ดึงข้อมูลจากตาราง categories
try {
    $sql = "SELECT category_id, category_name, image FROM categories";
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
    <title>จัดการหมวดหมู่</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include '../../Navbar_Admin.php'; ?>

        <!-- Include Menubar.php -->
        <?php include '../../Menubar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">จัดการหมวดหมู่</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <form method="post" class="form-inline me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="ค้นหาหมวดหมู่" name="search_value" value="<?php echo htmlspecialchars($search_value); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addCategoryModal"><i class="fas fa-plus"></i> เพิ่มหมวดหมู่</button>
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
                                                <th>รหัสหมวดหมู่</th>
                                                <th>ชื่อหมวดหมู่</th>
                                                <th>รูปภาพ</th>
                                                <th>การจัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['category_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                                    <td>
                                                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['category_name']); ?>" width="50">
                                                    </td>
                                                    <td>
                                                        <a href='../Edit/edit_category.php?category_id=<?php echo $row['category_id']; ?>' class='btn btn-warning'><i class="fas fa-edit"></i></a>
                                                        <a href='../Delete/delete_category.php?category_id=<?php echo $row['category_id']; ?>' class='btn btn-danger' onclick="return confirm('ยืนยันการลบข้อมูล?')"><i class="fas fa-trash"></i></a>
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

        <!-- Modal สำหรับเพิ่มหมวดหมู่ -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">เพิ่มหมวดหมู่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../Add/add_category.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category_name">ชื่อหมวดหมู่</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
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
