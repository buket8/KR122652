<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                if ($_SESSION['role'] == 'employer') {
                    header("Location: employer_dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                echo "Невалидна парола!";
            }
        } else {
            echo "Невалиден имейл!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Вход</title>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
        </div>
        <div class="nav-links">
            <a href="login.php" class="button">Вход</a>
            <a href="register.php" class="button">Създай профил</a>
        </div>
    </div>

    <div class="login-form">
        <h2>Вход</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Имейл" required>
            <input type="password" name="password" placeholder="Парола" required>
            <button type="submit" name="login">Вход</button>
        </form>
    </div>
</body>
</html>
