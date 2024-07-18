<?php
include 'db.php';

$categoryQuery = $db->query('SELECT * FROM categories');
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Categorias</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="category.php">Categorias</a>
            <a href="search.php">Buscar</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <main>
        <section id="categories">
            <?php foreach ($categories as $category): ?>
                <div>
                    <h3><?= htmlspecialchars($category['name']) ?></h3>
                    <a href="category_content.php?id=<?= $category['id'] ?>">View Content</a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Fap Flixx</p>
    </footer>
</body>
</html>
