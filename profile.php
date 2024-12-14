<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Грешка при зареждане на профила.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $update_query = "UPDATE users SET name = ?, email = ?, phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    
    if ($stmt->execute()) {
        $message = "<p style='color: green;'>Профилът е обновен успешно!</p>";
    } else {
        $message = "<p style='color: red;'>Грешка при обновяване на профила: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Профил</title>
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <a href="index.php"><img src="logo/rabota.bg.png" alt="Лого" class="logo-img" /></a>
        </div>
        <div class="nav-links">
            <a href="profile.php" class="button">Профил</a>
            <a href="logout.php" class="button">Изход</a>
            <?php if ($user['user_role'] == 'employer') { ?>
                <a href="post_job.php" class="button">Качи обява</a>
            <?php } ?>
        </div>
    </div>

    <div class="profile section">
        <h2>Профил на <?php echo htmlspecialchars($user['name']); ?></h2>
        
        <?php if (isset($message)) { echo $message; } ?>
        
        <form method="POST" action="profile.php">
            <label for="name">Име:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

            <label for="phone">Телефон:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

            <button type="submit">Обнови профила</button>
        </form>
    </div>

</body>
</html>
