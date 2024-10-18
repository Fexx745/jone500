<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar คล้าย Shopee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar Customization */
        .navbar {
            background-color: #1E90FF; /* สีพื้นหลังของ Navbar เปลี่ยนเป็นสีฟ้า */
        }
        .navbar-brand {
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: white;
            font-size: 16px;
            padding: 10px 15px;
        }
        .navbar-nav .nav-link:hover {
            background-color: #0073e6; /* สีพื้นหลังเมื่อเอาเมาส์ไปวาง */
            border-radius: 5px;
        }
        /* Logout button customization */
        .navbar .logout-btn {
            background-color: white;
            color: #1E90FF;
            border-radius: 20px;
            padding: 8px 15px;
            border: 2px solid white;
            font-weight: bold;
            transition: 0.3s;
        }
        .navbar .logout-btn:hover {
            background-color: #0073e6;
            color: white;
            border-color: #0073e6;
        }
        /* Custom CSS for placing the Logout button to the right */
        .logout-btn {
            margin-left: auto; /* ทำให้ปุ่ม Logout อยู่ด้านขวาสุด */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container d-flex">
        <a class="navbar-brand" href="#">JONE $ 500</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- ปุ่ม Logout -->
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
