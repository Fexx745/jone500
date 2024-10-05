<?php
session_start();
session_destroy();
header("Location: login.php");
exit(); // ป้องกันการทำงานต่อหลังจาก redirect
?>