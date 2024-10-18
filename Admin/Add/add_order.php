php
คัดลอกโค้ด
<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าข้อมูลจากฟอร์ม
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $total_price = $_POST['total_price'];
    $order_status = $_POST['order_status'];

    // เพิ่มข้อมูลคำสั่งซื้อใหม่ในฐานข้อมูล
    try {
        $sql = "INSERT INTO tb_orders (customer_id, order_date, total_price, order_status) VALUES (:customer_id, :order_date, :total_price, :order_status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':order_status', $order_status);
        $stmt->execute();

        // ถ้ามีการเพิ่มสำเร็จ
        echo "<script>alert('เพิ่มคำสั่งซื้อสำเร็จ!'); window.location.href='../Manage/manage_orders.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>