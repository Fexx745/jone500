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
  <?php include('banner.php'); ?>


  <div class="container mt-4">
    <h3 class="new">สินค้ามาใหม่</h3>
    <div class="row">
      <?php
      include('assets/condb/condb.php');

      $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 12";
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
            <div class="col-md-3 mb-3">
              <a href="product_detail.php?productId=<?= $row['product_id']; ?>" class="text-decoration-none">
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
              </a>
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

      $sql = "SELECT category_id, category_name, image FROM categories";
      $result = $conn->query($sql);

      if ($result) {
        if ($result->rowCount() > 0) {
          foreach ($result as $row) {
            echo '
          <div class="col-md-3 mb-4">
            <div class="card text-center">
              <a href="category.php?category_id=' . $row["category_id"] . '">
                <img src="assets/imge/category/' . $row["image"] . '" class="card-img-top" alt="">
              </a>
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

  </div>
</body>

</html>


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
        <a class="btn btn-success" href="login.php">เข้าสู่ระบบ</a>
      </div>
    </div>
  </div>
</div>

<div class="main-content"></div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const overlay = document.getElementById("overlay");
    const confirmButton = document.getElementById("confirmButton");

    const hasVisited = localStorage.getItem("hasVisited");

    if (!hasVisited) {
      overlay.style.display = "block";
      overlay.classList.add('show');
      overlay.setAttribute('aria-hidden', 'false');
    } else {
      overlay.style.display = "none";
      overlay.classList.remove('show');
      overlay.setAttribute('aria-hidden', 'true');
    }

    confirmButton.addEventListener("click", function() {
      overlay.style.display = "none";
      overlay.classList.remove('show');
      overlay.setAttribute('aria-hidden', 'true');
      localStorage.setItem("hasVisited", "true");
    });
  });
</script>