<?php
include('../../assets/condb/condb.php'); // เปลี่ยนเส้นทางให้ถูกต้อง

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $product_name = $_POST['product_name'];
    $product_detail = $_POST['product_detail'];
    $price = $_POST['price'];
    $stockQty = $_POST['stockQty'];
    $size = $_POST['size'];
    $category_id = $_POST['category_id'];
    
    // ตรวจสอบและจัดการไฟล์รูปภาพ
    $target_dir = "../../assets/imge/product/"; // โฟลเดอร์สำหรับเก็บรูปภาพ
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // ตรวจสอบว่ารูปภาพเป็นไฟล์จริงหรือไม่
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ.";
        $uploadOk = 0;
    }
    
    // ตรวจสอบขนาดไฟล์ (สูงสุด 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        echo "ขอโทษครับ รูปภาพของคุณใหญ่เกินไป.";
        $uploadOk = 0;
    }
    
    // ตรวจสอบนามสกุลไฟล์
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "ขอโทษครับ เราเพียงรับไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
        $uploadOk = 0;
    }
    
    // ตรวจสอบว่ามีปัญหาในการอัปโหลดไฟล์
    if ($uploadOk == 0) {
        echo "ขอโทษครับ ไม่สามารถอัปโหลดรูปภาพได้.";
    } else {
        // พยายามอัปโหลดไฟล์
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
            try {
                $sql = "INSERT INTO products (product_name, product_detail, price, stockQty, size, category_id, image, created_at) 
                        VALUES (:product_name, :product_detail, :price, :stockQty, :size, :category_id, :image, NOW())";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':product_detail', $product_detail);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':stockQty', $stockQty);
                $stmt->bindParam(':size', $size);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':image', $target_file);

                if ($stmt->execute()) {
                    echo "เพิ่มสินค้าสำเร็จ!";
                    header("Location: ../Manage/manage_products.php");
                    exit();
                } else {
                    echo "เกิดข้อผิดพลาดในการเพิ่มสินค้า.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.";
        }
    }
}
?>