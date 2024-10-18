<?php
include('../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;

    // ตรวจสอบค่าที่รับมาว่าถูกต้องหรือไม่
    if ($order_id && $product_id && $quantity > 0 && $price > 0) {
        try {
            // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
            $sql = "INSERT INTO tb_order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt = $conn->prepare($sql);
            
            // ผูกค่าพารามิเตอร์
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':price', $price);
            
            // ดำเนินการคำสั่ง SQL
            $stmt->execute();

            // แสดงผลสำเร็จและกลับไปยังหน้าที่เกี่ยวข้อง
            echo "<script>alert('เพิ่มรายละเอียดคำสั่งซื้อสำเร็จ'); window.location.href='../path_to_your_page.php';</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน'); window.history.back();</script>";
    }
} else {
    // ถ้ามาที่หน้านี้โดยตรงโดยไม่ใช่ POST ให้เปลี่ยนเส้นทางไปหน้าที่ต้องการ
    header('Location: ../path_to_your_page.php');
    exit();
}
?>
