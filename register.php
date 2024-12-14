<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $error = "Имейлът вече е зает.";
        } elseif (strlen($password) < 8) {
            $error = "Паролата трябва да бъде поне 8 символа.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
                mysqli_stmt_bind_param($stmt_insert, "ssss", $username, $email, $hashed_password, $role);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $success = "Регистрацията беше успешна!";
                } else {
                    $error = "Грешка при регистрацията.";
                }
                mysqli_stmt_close($stmt_insert);
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Регистрация</title>
</head>
<body>
<script src="register.js"></script>
<div class="navbar">
    <div class="logo">
        <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
    </div>
    <div class="nav-links">
        <a href="login.php" class="button">Вход</a>
        <a href="register.php" class="button">Регистрация</a>
    </div>
</div>
<div class="register-form">
    <h2>Регистрация</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">Потребителско име:</label>
            <input type="text" name="username" id="username" required />
        </div>
        <div class="form-group">
            <label for="email">Имейл:</label>
            <input type="email" name="email" id="email" required />
        </div>
        <div class="form-group">
            <label for="password">Парола:</label>
            <input type="password" name="password" id="password" required pattern=".{8,}" title="Паролата трябва да бъде поне 8 символа." />
        </div>
        <div class="form-group">
            <label for="role">Роля:</label>
            <select name="role" id="role">
                <option value="employer">Работодател</option>
                <option value="candidate">Кандидат</option>
            </select>
        </div>
        <button type="submit">Регистрирай се</button>
    </form>
</div>
</body>
</html>
