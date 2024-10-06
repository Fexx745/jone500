<?php
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

unset($_SESSION['customer_id']);
unset($_SESSION['email']);

$_SESSION['cart'] = $cart;

header("Location: login.php");
exit();
?>