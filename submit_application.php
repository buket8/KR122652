<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $phone = $_POST['phone'];
    $cover_letter = $_POST['cover_letter'];
    $upload_dir = 'uploads/cvs/';

    $allowed_extensions = ['pdf', 'doc', 'docx'];
    $file_extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);

    if (!in_array($file_extension, $allowed_extensions)) {
        echo '<div class="error-message">Моля, качете файл с разрешено разширение (.pdf, .doc, .docx).</div>';
        exit;
    }

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . basename($_FILES['cv']['name']);
    if (move_uploaded_file($_FILES['cv']['tmp_name'], $file_path)) {
        $user_id = $_SESSION['user_id'];
        $application_date = date('Y-m-d H:i:s');

        $query = "INSERT INTO applications (user_id, job_id, phone_number, cv_file, motivation_letter, application_date)
                  VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "iissss", $user_id, $job_id, $phone, $file_path, $cover_letter, $application_date);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Кандидатурата е подадена успешно!";
            } else {
                $error_message = "Грешка при подаване на кандидатурата: " . mysqli_error($conn);
            }
        }
    } else {
        $error_message = "Грешка при качване на файла.";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кандидатстване</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
    </div>
    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="button">Моят профил</a>
            <a href="logout.php" class="button">Изход</a>
        <?php else: ?>
            <a href="login.php" class="button">Вход</a>
            <a href="register.php" class="button">Създай профил</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
</div>

<script>
    setTimeout(() => {
        const messages = document.querySelectorAll('.success-message, .error-message');
        messages.forEach(message => {
            message.style.transition = 'opacity 1s ease-out';
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 1000);
        });
    }, 3000);
</script>

</body>
</html>
