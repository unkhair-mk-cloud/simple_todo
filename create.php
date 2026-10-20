<?php
$host = '10.10.10.12';
$db   = 'app_db';
$user = 'root';
$pass = 'P@ssw0rd-db';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method not allowed.');
    }

    $task = trim($_POST['task'] ?? '');

    if ($task === '' || mb_strlen($task) > 50) {
        exit('Task must contain 1–50 characters.');
    }

    $stmt = $pdo->prepare('INSERT INTO todo (task) VALUES (?)');
    $stmt->execute([$task]);

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    exit('Unable to save task.');
}
