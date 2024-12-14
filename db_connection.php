<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'job_platform';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Грешка при свързване с базата данни: ' . $conn->connect_error);
}
?>
