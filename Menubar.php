<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menubar Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh; /* ตั้งความสูงให้ Sidebar เต็ม */
            position: fixed; /* ทำให้ Sidebar ติดอยู่ที่ด้านข้าง */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        .content {
            margin-left: 200px; /* เว้นระยะซ้ายสำหรับ Sidebar */
            padding: 20px; /* เพิ่ม Padding ให้กับเนื้อหา */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1; /* ทำให้เนื้อหาขยายเต็มพื้นที่ที่เหลือ */
            margin-top: 0; /* ไม่มี margin ด้านบน */
        }
    </style>
</head>
<body>
    <div class="d-flex" style="height: 100vh;">
        <div class="bg-success text-white sidebar">
            <ul class="nav flex-column pt-3">
                <li class="nav-item">
                    <a id="manage-attention-importance-link" href="../admin_dashboard.php" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a id="about-link" href="../Manage/manage_admin.php" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        Admin
                    </a>
                </li>
                <li class="nav-item">
                    <a id="services-link" href="../Manage/manage_categories.php" class="nav-link">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a id="contact-link" href="../Manage/manage_products.php" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a id="help-link" href="../Manage/manage_orders.php" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a id="help-link" href="../Manage/manage_order_details.php" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        Order_Details
                    </a>
                </li>
                <li class="nav-item">
                    <a id="help-link" href="../Manage/manage_payments.php" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        Payments
                    </a>
                </li>
                <li class="nav-item">
                    <a id="help-link" href="../Manage/manage_shipping.php" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        Shipping
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
