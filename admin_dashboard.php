<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh; /* ตั้งความสูงให้ Sidebar เต็ม */
            position: fixed; /* ทำให้ Sidebar ติดอยู่ที่ด้านข้าง */
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
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Include Navbar_Admin.php -->
        <?php include 'Navbar_Admin.php'; ?>
        
        <!-- Include Menubar.php -->
        <?php include 'Menubar.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
</body>
</html>
