<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ดึงค่าจากฟอร์ม
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
    $shipping_address = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';
    $shipping_method = isset($_POST['shipping_method']) ? $_POST['shipping_method'] : '';
    $shipping_date = isset($_POST['shipping_date']) ? $_POST['shipping_date'] : '';
    $tracking_number = isset($_POST['tracking_number']) ? $_POST['tracking_number'] : '';

    // ตรวจสอบว่ามีข้อมูลที่จำเป็นทั้งหมดหรือไม่
    if (!empty($order_id) && !empty($shipping_address) && !empty($shipping_method) && !empty($shipping_date) && !empty($tracking_number)) {
        try {
            // ตรวจสอบว่า order_id มีอยู่ใน tb_orders หรือไม่
            $checkOrderSql = "SELECT COUNT(*) FROM tb_orders WHERE order_id = :order_id";
            $checkStmt = $conn->prepare($checkOrderSql);
            $checkStmt->bindParam(':order_id', $order_id);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                // order_id มีอยู่ใน tb_orders
                $sql = "INSERT INTO shipping (order_id, shipping_address, shipping_method, shipping_date, tracking_number) 
                        VALUES (:order_id, :shipping_address, :shipping_method, :shipping_date, :tracking_number)";
                $stmt = $conn->prepare($sql);

                // ผูกค่าพารามิเตอร์
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':shipping_address', $shipping_address);
                $stmt->bindParam(':shipping_method', $shipping_method);
                $stmt->bindParam(':shipping_date', $shipping_date);
                $stmt->bindParam(':tracking_number', $tracking_number);

                // ดำเนินการคำสั่ง SQL
                if ($stmt->execute()) {
                    echo "<script>alert('เพิ่มการจัดส่งสำเร็จ!'); window.location.href = '../Manage/manage_shipping.php';</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล!'); history.back();</script>";
                }
            } else {
                // order_id ไม่พบใน tb_orders
                echo "<script>alert('ไม่พบ order_id นี้ในระบบ!'); history.back();</script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน!'); history.back();</script>";
    }
} else {
    // ถ้าไม่ใช่การ POST ให้ส่งกลับไปยังหน้าเดิม
    header("Location: ../Manage/manage_shipping.php");
    exit();
}
