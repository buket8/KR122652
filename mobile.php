<?php 
include 'db_connection.php';

$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);
    $query = "SELECT * FROM jobs WHERE category = 'Mobile' AND (title LIKE '%$search_term%' OR description LIKE '%$search_term%')";
} else {
    $query = "SELECT * FROM jobs WHERE category = 'Mobile'";
}

$result = $conn->query($query);

if (!$result) {
    die("Грешка при изпълнение на заявката: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Обяви за работа - Mobile</title>
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

    <div class="search">
        <form method="POST" action="">
            <input type="text" name="search_term" placeholder="Търси работа..." value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit" name="search" class="button">Търси</button>
        </form>
    </div>

    <div class="job-list">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="job">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($row['description']), 0, 150); ?>...</p>
                    <p><strong>Компания:</strong> <?php echo htmlspecialchars($row['company']); ?></p>
                    <p><strong>Локация:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <a href="view_jobs.php?id=<?php echo $row['job_id']; ?>" class="button">Прочети повече</a>
                </div>
                <?php
            }
        } else {
            echo "<p>Няма публикувани обяви за работа в категория Mobile.</p>";
        }
        ?>
    </div>

</body>
</html>
