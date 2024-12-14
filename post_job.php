<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $company = $_POST['company'];

    $query = "INSERT INTO jobs (title, description, salary, location, company, created_at) 
              VALUES (?, ?, ?, ?, ?, NOW())";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "sssss", $title, $description, $salary, $location, $company);
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Обявата е качена успешно!";
        } else {
            $error_message = "Грешка при качване на обявата: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Качване на обява</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
    </div>
    <div class="nav-links">
        <a href="profile.php" class="button">Моят профил</a>
        <a href="logout.php" class="button">Изход</a>
    </div>
</div>

<div class="container">
    <h2>Качване на нова обява</h2>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="post_job.php" method="POST">
        <label for="title">Заглавие:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Описание:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="salary">Заплата:</label>
        <input type="text" id="salary" name="salary" required>

        <label for="location">Локация:</label>
        <input type="text" id="location" name="location" required>

        <label for="company">Компания:</label>
        <input type="text" id="company" name="company" required>

        <button type="submit" class="button">Качете обявата</button>
    </form>
</div>

</body>
</html>
