<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Obtener el ID de la categoría de la solicitud GET
$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($categoryId === 0) {
    echo "Categoría no válida.";
    exit;
}

// Recuperar el contenido de la categoría específica
$contentQuery = $db->prepare('SELECT * FROM content WHERE category_id = ?');
$contentQuery->execute([$categoryId]);
$content = $contentQuery->fetchAll(PDO::FETCH_ASSOC);

// Recuperar el nombre de la categoría
$categoryQuery = $db->prepare('SELECT name FROM categories WHERE id = ?');
$categoryQuery->execute([$categoryId]);
$category = $categoryQuery->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo "Categoría no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido de la Categoría <?= htmlspecialchars($category['name']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Contenido de la Categoría: <?= htmlspecialchars($category['name']) ?></h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="category.php">Categories</a>
            <a href="search.php">Search</a>
            <a href="login.php">Admin Login</a>
        </nav>
    </header>
    <main>
        <section id="content">
            <?php if (count($content) > 0): ?>
                <?php foreach ($content as $item): ?>
                    <div>
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                        <a href="<?= htmlspecialchars($item['media_url']) ?>" target="_blank">View Media</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay contenido en esta categoría.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Content Page</p>
    </footer>
</body>
</html>
