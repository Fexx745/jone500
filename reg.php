<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">ลงทะเบียน</h2>
        <form action="form/insert/reg_insert.php" method="post" class="row g-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">ชื่อ:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">นามสกุล:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label for="email" class="form-label">อีเมล:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label for="password" class="form-label">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">โทรศัพท์:</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="postal_code" class="form-label">รหัสไปรษณีย์:</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">ที่อยู่:</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-6">
                <label for="city" class="form-label">เมือง:</label>
                <input type="text" id="city" name="city" class="form-control" required>
            </div>
            <div class="col-12 text-center mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary w-100 me-2">ลงทะเบียน</button>
            </div>
            <div class="col-12 text-center mt-4 d-flex justify-content-between">
                <a href="login.php" class="btn btn-success w-100">เข้าสู่ระบบ</a>
            </div>
        </form>
    </div>



    <!-- Bootstrap 5 JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>