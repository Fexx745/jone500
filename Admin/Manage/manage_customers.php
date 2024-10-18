<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// กำหนดค่าพารามิเตอร์สำหรับการแบ่งหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$number_of_pages = 1; // กำหนดค่าเริ่มต้น หรือคำนวณจากจำนวนข้อมูล

// ดึงข้อมูลจากตาราง tb_customers
try {
    $sql = "SELECT customer_id, first_name, last_name, email, phone, address, city, postal_code, reg_date, user_role 
            FROM tb_customers";
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
    <title>จัดการลูกค้า</title>
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
                            <h1 class="m-0">จัดการลูกค้า</h1>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <form method="post" class="form-inline me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="ค้นหาลูกค้า" name="search_value" value="<?php echo htmlspecialchars($search_value); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <button class="btn btn-success" data-toggle="modal" data-target="#addCustomerModal"><i class="fas fa-plus"></i> เพิ่มลูกค้า</button>
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
                                                <th>รหัสลูกค้า</th>
                                                <th>ชื่อ</th>
                                                <th>นามสกุล</th>
                                                <th>อีเมล</th>
                                                <th>เบอร์โทร</th>
                                                <th>ที่อยู่</th>
                                                <th>เมือง</th>
                                                <th>รหัสไปรษณีย์</th>
                                                <th>วันที่ลงทะเบียน</th>
                                                <th>บทบาทผู้ใช้</th>
                                                <th>การจัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['postal_code']); ?></td>
                                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['reg_date']))); ?></td>
                                                    <td><?php echo htmlspecialchars($row['user_role']); ?></td>
                                                    <td>
                                                        <a href='../Edit/edit_customer.php?customer_id=<?php echo $row['customer_id']; ?>' class='btn btn-warning'><i class="fas fa-edit"></i></a>
                                                        <a href='../Delete/delete_customer.php?customer_id=<?php echo $row['customer_id']; ?>' class='btn btn-danger' onclick="return confirm('ยืนยันการลบข้อมูล?')"><i class="fas fa-trash"></i></a>
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

        <!-- Modal สำหรับเพิ่มลูกค้า -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">เพิ่มลูกค้า</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../Add/add_customer.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first_name">ชื่อ</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">นามสกุล</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">อีเมล</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">เบอร์โทร</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="address">ที่อยู่</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="city">เมือง</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">รหัสไปรษณีย์</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                            </div>
                            <div class="form-group">
                                <label for="user_role">บทบาทผู้ใช้</label>
                                <select class="form-control" id="user_role" name="user_role" required>
                                    <option value="user">ผู้ใช้</option>
                                    <option value="admin">ผู้ดูแลระบบ</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
</body>

</html>
