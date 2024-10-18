<?php
session_start();

include_once '../../assets/condb/condb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $phone = $_POST['phone'];
    $postal_code = $_POST['postal_code'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $user_role = $_POST['user_role'];

    // ตรวจสอบว่ามีอีเมลนี้อยู่ในระบบแล้วหรือไม่
    $check_email_sql = "SELECT COUNT(*) FROM tb_customers WHERE email = :email";
    $stmt = $conn->prepare($check_email_sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $email_count = $stmt->fetchColumn();

    if ($email_count > 0) {
        echo "<script>
                alert('Error: This email is already registered.');
                window.location.href='reg.php';
              </script>";
    } else {
        // ถ้าอีเมลไม่ซ้ำให้ทำการบันทึกข้อมูลลงฐานข้อมูล
        $sql = "INSERT INTO tb_customers (first_name, last_name, email, password, phone, postal_code, address, city, user_role) 
                VALUES (:first_name, :last_name, :email, :password, :phone, :postal_code, :address, :city, :user_role)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':user_role', $user_role);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful!');
                    window.location.href='login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Could not complete registration.');
                    window.location.href='reg.php';
                  </script>";
        }
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href='reg.php';
          </script>";
}
?>
