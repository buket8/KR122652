<?php
session_start();
include('db_connection.php');

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $query = "SELECT * FROM jobs WHERE job_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $job_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $job = mysqli_fetch_assoc($result);

        if (!$job) {
            echo "<p>Обявата не съществува.</p>";
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allowed_extensions = ['pdf', 'doc', 'docx'];
    $file_extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);

    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Моля, качете файл с разрешено разширение (.pdf, .doc, .docx).";
        exit;
    }

    $phone = $_POST['phone'];
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "Моля, въведете валиден телефонен номер (10 цифри).";
        exit;
    }

    $upload_dir = 'uploads/cvs/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['cv']['tmp_name'], $upload_dir . basename($_FILES['cv']['name']))) {
        echo "Файлът е качен успешно.";
    } else {
        echo "Грешка при качване на CV-то.";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кандидатствай за обява</title>
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

<div class="job-details">
    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
    <p><strong>Описание:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
    <p><strong>Заплата:</strong> <?php echo htmlspecialchars($job['salary']); ?> лв.</p>
    <p><strong>Локация:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
    <p><strong>Компания:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
    <p><strong>Дата на обявата:</strong> <?php echo htmlspecialchars($job['created_at']); ?></p>
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="register-form">
        <h3>Подайте кандидатура</h3>
        <form action="submit_application.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">

            <div class="form-group">
                <label for="cv">Качете своето CV:</label>
                <input type="file" id="cv" name="cv" required>
            </div>

            <div class="form-group">
                <label for="phone">Телефонен номер:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="cover_letter">Мотивационно писмо:</label>
                <textarea id="cover_letter" name="cover_letter" rows="5" required></textarea>
            </div>

            <button type="submit">Кандидатствай</button>
        </form>
    </div>
<?php else: ?>
    <div class="alert">
        <p>Моля, влезте в профила си, за да кандидатствате за тази обява.</p>
    </div>
<?php endif; ?>

<script>
    window.onload = function() {
        const form = document.querySelector('form[action="submit_application.php"]');
        if (form) {
            form.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    };
</script>

</body>
</html>
