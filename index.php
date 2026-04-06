<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mes tâches</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .completed { text-decoration: line-through; color: gray; }
        a { margin-right: 10px; }
    </style>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> !</h1>
    
    <a href="add.php">➕ Ajouter une tâche</a>
    <a href="logout.php" style="float: right;">🚪 Se déconnecter</a>
    
    <h2>Mes tâches</h2>
    
    <?php
    // ATTENTION : PAS de created_at ici !
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $tasks = $stmt->fetchAll();
    ?>
    
    <?php if (empty($tasks)): ?>
        <p>Aucune tâche. <a href="add.php">Créez-en une !</a></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr class="<?= $task['status'] === 'terminé' ? 'completed' : '' ?>">
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description'] ?? '') ?></td>
                        <td><?= htmlspecialchars($task['status']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $task['id'] ?>">✏️ Modifier</a>
                            <a href="delete.php?id=<?= $task['id'] ?>" onclick="return confirm('Supprimer cette tâche ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>