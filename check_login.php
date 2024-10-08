<?php
session_start();

include_once 'assets/condb/condb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tb_customers WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_role'] = $user['user_role'];

            echo "<script>
                    alert('Login successful!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Incorrect email or password.');
                    window.location.href='login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Email not found.');
                window.location.href='login.php';
              </script>";
    }
}
?>
