<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

$employer_id = $_SESSION['user_id'];

$query = "SELECT * FROM job_ads WHERE employer_id = ? ORDER BY posted_at DESC";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $employer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Грешка при извличането на обявите!";
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Табло на работодателя</title>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
        </div>
        <div class="nav-links">
            <a href="logout.php" class="button">Изход</a>
        </div>
    </div>

    <div class="dashboard">
        <h2>Добре дошли, работодателю!</h2>
        <h3>Вашите обяви:</h3>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="job-listings">
                <thead>
                    <tr>
                        <th>Заглавие</th>
                        <th>Категория</th>
                        <th>Заплата</th>
                        <th>Местоположение</th>
                        <th>Дата на публикуване</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($job = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($job['title']); ?></td>
                            <td><?php echo htmlspecialchars($job['category']); ?></td>
                            <td><?php echo htmlspecialchars($job['salary']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($job['posted_at'])); ?></td>
                            <td>
                                <a href="edit_job.php?job_id=<?php echo $job['job_id']; ?>" class="button">Редактирай</a>
                                <a href="delete_job.php?job_id=<?php echo $job['job_id']; ?>" class="button">Изтрий</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Нямате публикувани обяви.</p>
        <?php endif; ?>
        
        <a href="post_job.php" class="button">Публикувай нова обява</a>
    </div>
</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
