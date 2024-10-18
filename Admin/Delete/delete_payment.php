<?php
include('../../assets/condb/condb.php');

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // ดึงข้อมูลการชำระเงินเพื่อตรวจสอบก่อนลบ
    try {
        $sql = "SELECT receipt_image FROM tb_payments WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
        $stmt->execute();
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$payment) {
            echo "ไม่พบข้อมูลการชำระเงิน";
            exit;
        }

        // ลบรูปภาพใบเสร็จ (ถ้ามี)
        if ($payment['receipt_image'] && file_exists($payment['receipt_image'])) {
            unlink($payment['receipt_image']);
        }

        // ลบข้อมูลการชำระเงินจากตาราง tb_payments
        $sql = "DELETE FROM tb_payments WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "ลบข้อมูลสำเร็จ";
        header("Location: ../View/view_payments.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "ไม่พบ ID การชำระเงิน";
    exit;
}
?>
