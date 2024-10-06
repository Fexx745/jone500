<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Update this path accordingly -->
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>ตะกร้าสินค้า</h1>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>รูปสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                        <th>รวม</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    foreach ($_SESSION['cart'] as $key => $item) :
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalPrice += $itemTotal;
                    ?>
                        <tr>
                            <td><img src="assets/imge/product/<?= $item['image']; ?>" class="img-fluid" alt="<?= $item['product_name']; ?>" width="50"></td>
                            <td><?= $item['product_name']; ?></td>
                            <td>
                                <a href="Cart_Update.php?productId=<?= $item['product_id']; ?>&action=decrease" class="btn btn-secondary btn-sm">-</a>
                                <?= $item['quantity']; ?>
                                <a href="Cart_Update.php?productId=<?= $item['product_id']; ?>&action=increase" class="btn btn-secondary btn-sm">+</a>
                            </td>
                            <td><?= $item['price']; ?> $</td>
                            <td><?= $itemTotal; ?> $</td>
                            <td>
                                <a href="Cart_Update.php?productId=<?= $item['product_id']; ?>&action=remove" class="btn btn-danger btn-sm">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end">
                <h3>ราคารวม: <?= $totalPrice; ?> $</h3>
                <form action="cart_insert.php" method="POST">
                    <input type="hidden" name="totalPrice" value="<?= $totalPrice; ?>">
                    <button type="submit" class="btn btn-success">สั่งซื้อ</button>
                </form>
            </div>
        <?php else : ?>
            <p>ไม่มีสินค้าในตะกร้า</p>
        <?php endif; ?>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
</body>

</html>