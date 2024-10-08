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
                            <td><?= number_format($item['price'], 2); ?> $</td>
                            <td><?= number_format($itemTotal, 2); ?> $</td>
                            <td>
                                <a href="Cart_Update.php?productId=<?= $item['product_id']; ?>&action=remove" class="btn btn-danger btn-sm">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Shipping Options -->
            <form action="cart_insert.php" method="POST">
                <div class="form-group">
                    <label for="shipping">เลือกวิธีการจัดส่ง:</label>
                    <select name="shipping_id" id="shipping" class="form-control" required>
                        <option value="" disabled selected>กรุณาเลือกขนส่ง</option> <!-- Default Option -->
                        <?php
                        // Fetch available shipping methods
                        include('assets/condb/condb.php');
                        $sql = "SELECT shipping_id, shipping_method, shipping_price FROM shipping";
                        $result = $conn->query($sql);

                        if ($result && $result->rowCount() > 0) {
                            foreach ($result as $shipping) {
                                echo '<option value="' . $shipping['shipping_id'] . '" data-price="' . $shipping['shipping_price'] . '">'
                                    . $shipping['shipping_method'] . ' - ' . number_format($shipping['shipping_price'], 2) . ' $</option>';
                            }
                        } else {
                            echo '<option value="">ไม่มีวิธีการจัดส่ง</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Display total price with shipping -->
                <div class="text-end">
                    <h3>ราคารวมสินค้า: <span id="product-total"><?= number_format($totalPrice, 2); ?> $</span></h3>
                    <h3>ค่าจัดส่ง: <span id="shipping-fee">0.00 $</span></h3>
                    <h3>ราคารวมทั้งหมด: <span id="total-price"><?= number_format($totalPrice, 2); ?> $</span></h3>
                </div>

                <input type="hidden" name="totalPrice" id="totalPriceInput" value="<?= $totalPrice; ?>">
                <button type="submit" class="btn btn-success">สั่งซื้อ</button>
            </form>
        <?php else : ?>
            <p>ไม่มีสินค้าในตะกร้า</p>
        <?php endif; ?>
    </div>

    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Update this path accordingly -->
    <script>
        // Update total price when shipping option is selected
        const shippingSelect = document.getElementById('shipping');
        const productTotal = parseFloat(<?= $totalPrice; ?>);
        const shippingFeeDisplay = document.getElementById('shipping-fee');
        const totalPriceDisplay = document.getElementById('total-price');
        const totalPriceInput = document.getElementById('totalPriceInput');

        // Initialize total price to product total
        totalPriceInput.value = productTotal; // Set initial total price for form submission

        shippingSelect.addEventListener('change', function() {
            const shippingPrice = parseFloat(this.selectedOptions[0].getAttribute('data-price'));
            shippingFeeDisplay.textContent = shippingPrice.toFixed(2) + ' $';
            const finalTotal = productTotal + shippingPrice;
            totalPriceDisplay.textContent = finalTotal.toFixed(2) + ' $';
            totalPriceInput.value = finalTotal; // Update hidden input for form submission
        });
    </script>
</body>

</html>