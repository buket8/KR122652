<?php
session_start();
include('db_connection.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $job_id = $_GET['id'];
    $query = "SELECT * FROM jobs WHERE job_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $job_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $job = mysqli_fetch_assoc($result);
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Подробности за обява</title>
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

    <div class="job-details">
        <?php if (isset($job)): ?>
            <h2><?php echo htmlspecialchars($job['title']); ?></h2>
            <p><strong>Описание:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
            <p><strong>Заплата:</strong> <?php echo htmlspecialchars($job['salary']); ?> лв.</p>
            <p><strong>Локация:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Компания:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
            <p><strong>Дата на обявата:</strong> <?php echo htmlspecialchars($job['created_at']); ?></p>

            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="apply.php?id=<?php echo $job_id; ?>" class="button">Кандидатствай</a>
            <?php } else { ?>
                <p>Моля, влезте в профила си, за да кандидатствате.</p>
            <?php } ?>
        <?php else: ?>
            <p>Обявата не беше намерена.</p>
        <?php endif; ?>
    </div>
</body>
</html>
