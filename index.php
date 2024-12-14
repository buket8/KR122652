<?php 
include 'db_connection.php';

$search_term = '';
$query = "SELECT * FROM jobs";

if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $query = "SELECT * FROM jobs WHERE title LIKE ? OR description LIKE ?";
}

if ($stmt = $conn->prepare($query)) {
    if (isset($_POST['search'])) {
        $search_param = "%" . $search_term . "%";
        $stmt->bind_param("ss", $search_param, $search_param); 
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Грешка при подготовката на заявката: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Платформа за обяви за работа</title>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
    </div>
    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="button">Профил</a>
            <a href="logout.php" class="button">Изход</a>
            <?php if ($_SESSION['role'] == 'employer'): ?>
                <a href="create_job.php" class="button">Качи обява</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php" class="button">Вход</a>
            <a href="register.php" class="button">Създай профил</a>
        <?php endif; ?>
    </div>
</div>

<div class="search section">
    <form method="POST" action="">
        <input type="text" name="search_term" placeholder="Търси работа..." value="<?php echo htmlspecialchars($search_term); ?>">
        <button type="submit" name="search" class="button">Търси</button>
    </form>
</div>

<div class="category-section section">
    <a href="frontend.php" class="category-box">Frontend Development</a>
    <a href="backend.php" class="category-box">Backend Development</a>
    <a href="fullstack.php" class="category-box">Fullstack Development</a>
    <a href="mobile.php" class="category-box">Mobile Development</a>
</div>

<div class="job-list section" id="job-list">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="job">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo substr(htmlspecialchars($row['description']), 0, 150); ?>...</p>
                <p><strong>Компания:</strong> <?php echo htmlspecialchars($row['company']); ?></p>
                <p><strong>Локация:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <a href="view_jobs.php?id=<?php echo $row['job_id']; ?>" class="view-more">Прочети повече</a>
            </div>
            <?php
        }
    } else {
        echo "<p>Няма публикувани обяви за работа.</p>";
    }
    ?>
</div>

<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault();
            var searchTerm = $('input[name="search_term"]').val();

            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: { search_term: searchTerm, search: true },
                success: function(response) {
                    $('#job-list').html($(response).find('#job-list').html());
                },
                error: function() {
                    alert('Грешка при търсенето на обяви.');
                }
            });
        });
    });
</script>

</body>
</html>
