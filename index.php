<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

  <link rel="icon" href="assets/imge/icon.png">
  <link rel="stylesheet" href="assets/js/script.js">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
  <title>JONE $ 500</title>
</head>

<body>
  <?php include('navbar.php'); ?>

  <div class="container mt-4">
    <h3 class="new">สินค้ามาใหม่</h3>
    <div class="row">
      <?php
      include('assets/condb/condb.php');

      $sql = "SELECT product_name, product_detail, price, size, image FROM products ORDER BY created_at DESC LIMIT 12";
      $result = $conn->query($sql);

      if ($result) {
        $products = $result->fetchAll(PDO::FETCH_ASSOC);

        if (count($products) > 0) {
          foreach ($products as $row) {
            $size = $row["size"];
            $image = $row["image"];
            $productName = $row["product_name"];
            $productDetail = $row["product_detail"];
            $price = $row["price"];
      ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100">
                <div class="card-img-top text-center">
                  <div class="bb">
                    <p><?= $size; ?></p>
                  </div>
                  <img src="assets/imge/product/<?= $image; ?>" class="img-fluid" alt="<?= $productName; ?>">
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?= $productName; ?></h5>
                  <p class="card-text"><?= $productDetail; ?></p>
                </div>
                <div class="card-footer text-center">
                  <span class="text-muted"><?= $price; ?> $</span>
                </div>
              </div>
            </div>
      <?php
          }
        } else {
          echo "ไม่มีสินค้า";
        }
      } else {
        echo "เกิดข้อผิดพลาดในการดึงข้อมูล";
      }

      $conn = null;
      ?>
    </div>




    <!-- categories -->
    <h3 class="new mt-5">หมวดสินค้า</h3>
    <div class="row">
      <?php
      include('assets/condb/condb.php');

      $sql = "SELECT category_name, image FROM categories";
      $result = $conn->query($sql);

      if ($result) {
        if ($result->rowCount() > 0) {
          foreach ($result as $row) {
            echo '
              <div class="col-md-3 mb-4">
                <div class="card text-center">
                  <img src="assets/imge/category/' . $row["image"] . '" class="card-img-top" alt="">
                  <div class="card-body">
                    <p class="card-text">' . $row["category_name"] . '</p>
                  </div>
                </div>
              </div>';
          }
        } else {
          echo "ไม่มีประเภทสินค้า";
        }
      } else {
        echo "เกิดข้อผิดพลาดในการดึงข้อมูล";
      }

      $conn = null;
      ?>
    </div>



    <!-- new product -->
    <h3 class="new mt-5">สินค้ามาใหม่</h3>
    <div class="row">
      <?php
      include('assets/condb/condb.php');
      $sql = "SELECT product_name, product_detail, price, size, image FROM products ORDER BY created_at DESC LIMIT 10";
      $result = $conn->query($sql);

      if ($result) {
        if ($result->rowCount() > 0) {
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '
              <div class="col-md-4 mb-4">
                <div class="card h-100">
                  <div class="card-img-top text-center">
                    <div class="bb">
                      <p>' . $row["size"] . '</p>
                    </div>
                    <img src="assets/imge/product/' . $row["image"] . '" class="img-fluid" alt="' . $row["product_name"] . '">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">' . $row["product_name"] . '</h5>
                    <p class="card-text">' . $row["product_detail"] . '</p>
                  </div>
                  <div class="card-footer text-center">
                    <span class="text-muted">' . $row["price"] . ' $</span>
                  </div>
                </div>
              </div>';
          }
        } else {
          echo "ไม่มีสินค้าใหม่";
        }
      } else {
        echo "เกิดข้อผิดพลาดในการดึงข้อมูล";
      }

      $conn = null;
      ?>
    </div>
  </div>

  <div class="modal fade show" id="overlay" tabindex="-1" aria-labelledby="overlayLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="overlayLabel">ยินดีต้อนรับ!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p>กรุณากด "ตกลง" เพื่อเข้าสู่ร้านค้า</p>
          <img src="assets/imge/rev.jpg" alt="" class="img-fluid mb-3"><br>
        </div>
        <div class="modal-footer">
          <button id="confirmButton" class="btn btn-primary">ตกลง</button>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const overlay = document.getElementById("overlay");
      const confirmButton = document.getElementById("confirmButton");

      confirmButton.addEventListener("click", function() {
        overlay.style.display = "none";
        overlay.classList.remove('show');
        overlay.setAttribute('aria-hidden', 'true');
      });
    });
  </script>
</body>

</html>