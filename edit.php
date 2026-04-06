<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: index.php");
    exit();
}

if ($_POST) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    
    if (empty($title)) {
        $error = "Le titre est obligatoire";
    } else {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $status, $id, $_SESSION['user_id']]);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier une tâche</title>
</head>
<body>
    <h1>Modifier la tâche</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br><br>
        <textarea name="description" rows="3" cols="40"><?= htmlspecialchars($task['description'] ?? '') ?></textarea><br><br>
        
        <select name="status">
            <option value="en cours" <?= $task['status'] === 'en cours' ? 'selected' : '' ?>>En cours</option>
            <option value="terminé" <?= $task['status'] === 'terminé' ? 'selected' : '' ?>>Terminé</option>
        </select><br><br>
        
        <button type="submit">Enregistrer</button>
        <a href="index.php">Annuler</a>
    </form>
</body>
</html>