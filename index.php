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
} catch (PDOException $e) {
    exit('Database connection failed.');
}

$stmt = $pdo->query('SELECT id, task FROM todo ORDER BY id DESC');
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo App</title>
</head>
<body>
    <h1>Todo App</h1>

    <form action="create.php" method="POST">
        <label for="task">New task:</label>
        <input
            type="text"
            id="task"
            name="task"
            maxlength="50"
            required
        >
        <button type="submit">Add Task</button>
    </form>

    <h2>Task List</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= (int) $task['id'] ?></td>
                    <td><?= htmlspecialchars($task['task'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <form action="delete.php" method="POST">
                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $task['id'] ?>"
                            >
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($tasks)): ?>
                <tr>
                    <td colspan="3">No tasks yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
