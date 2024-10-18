<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // ควรเข้ารหัสรหัสผ่าน
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $user_role = $_POST['user_role'];

    // เข้ารหัสรหัสผ่าน (หากไม่ต้องการ hash password จะไม่ใช้โค้ดนี้)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // สร้างคำสั่ง SQL สำหรับเพิ่มข้อมูลลูกค้า
        $sql = "INSERT INTO tb_customers (first_name, last_name, email, password, phone, address, city, postal_code, user_role, reg_date) 
                VALUES (:first_name, :last_name, :email, :password, :phone, :address, :city, :postal_code, :user_role, NOW())";
        
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // หรือใช้ $hashed_password ถ้าต้องการ hash
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':user_role', $user_role);
        
        // ดำเนินการเพิ่มข้อมูล
        $stmt->execute();

        // ถ้าสำเร็จ จะ redirect ไปที่หน้าแรกของการจัดการลูกค้า
        header('Location: ../Manage/manage_customers.php?message=เพิ่มลูกค้าเรียบร้อยแล้ว');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
