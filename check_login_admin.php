<?php
session_start();

include_once 'assets/condb/condb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tb_admin WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
        
            echo "<script>
                    alert('เข้าสู่ระบบสำเร็จ!');
                    window.location.href='admin/admin_dashboard.php';
                  </script>";
        } else {
            echo "<script>
                    alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง.');
                    window.location.href='loginadmin.php';
                  </script>";
        }
    } 
}
?>
