<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_POST) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    
    if (empty($title)) {
        $error = "Le titre est obligatoire";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, user_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $_SESSION['user_id']]);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter une tâche</title>
</head>
<body>
    <h1>Ajouter une tâche</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="title" placeholder="Titre" required><br><br>
        <textarea name="description" placeholder="Description"></textarea><br><br>
        <button type="submit">Ajouter</button>
        <a href="index.php">Annuler</a>
    </form>
</body>
</html>