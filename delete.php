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

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        http_response_code(400);
        exit('Invalid task ID.');
    }

    $stmt = $pdo->prepare('DELETE FROM todo WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    exit('Unable to delete task.');
}
