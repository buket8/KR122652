<?php 
include 'db_connection.php';

$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);
    $query = "SELECT * FROM jobs WHERE (category = 'Frontend Development' OR category = 'Frontend') AND (title LIKE ? OR description LIKE ?)";
    $stmt = $conn->prepare($query);
    $search_term_wildcard = '%' . $search_term . '%';
    $stmt->bind_param('ss', $search_term_wildcard, $search_term_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM jobs WHERE (category = 'Frontend Development' OR category = 'Frontend') AND (title LIKE ? OR description LIKE ?)";
    $stmt = $conn->prepare($query);
    $search_term_wildcard = '%';
    $stmt->bind_param('ss', $search_term_wildcard, $search_term_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();
}

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
    <title>Обяви за работа - Frontend</title>
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
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $description = $row['description'];
                $salary = $row['salary'];
                $location = $row['location'];
                $company = $row['company'];
                $created_at = $row['created_at'];

                echo "
                <div class='job'>
                    <h3>$title</h3>
                    <p><strong>Компания:</strong> $company</p>
                    <p><strong>Заплата:</strong> $salary лв.</p>
                    <p><strong>Локация:</strong> $location</p>
                    <p><strong>Описание:</strong> $description</p>
                    <p><strong>Публикувана на:</strong> $created_at</p>
                    <a href='apply.php?id={$row['job_id']}' class='button'>Кандидатствай</a>
                </div>";
            }
        } else {
            echo "<p>Няма обяви за работа в категория Frontend.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
