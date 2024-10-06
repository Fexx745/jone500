<?php
session_start();

if (isset($_GET['productId']) && isset($_GET['action'])) {
    $productId = $_GET['productId'];
    $action = $_GET['action'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $productId) {
                if ($action == 'remove') {
                    unset($_SESSION['cart'][$key]);
                }
                elseif ($action == 'increase') {
                    $_SESSION['cart'][$key]['quantity'] += 1;
                }
                elseif ($action == 'decrease') {
                    if ($_SESSION['cart'][$key]['quantity'] > 1) {
                        $_SESSION['cart'][$key]['quantity'] -= 1;
                    } else {
                        unset($_SESSION['cart'][$key]);
                    }
                }
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

header("Location: cart.php");
exit;
