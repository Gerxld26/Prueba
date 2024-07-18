<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$content = [];

if (!empty($search_query)) {
    $query = $db->prepare('SELECT * FROM content WHERE title LIKE ? OR description LIKE ?');
    $like_search_query = '%' . $search_query . '%';
    $query->execute([$like_search_query, $like_search_query]);
    $content = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Content</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>Search Content</h1>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Admin Login</a>
                        </li>
                    </ul>
                    <form class="form-inline ml-auto" action="search.php" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="q" placeholder="Search" aria-label="Search" value="<?= htmlspecialchars($search_query) ?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <h2>Search Results for "<?= htmlspecialchars($search_query) ?>"</h2>
        <section id="content" class="row">
            <?php if (!empty($content)): ?>
                <?php foreach ($content as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if ($item['thumbnail_url']): ?>
                                <a href="<?= htmlspecialchars($item['media_url']) ?>" target="_blank">
                                    <img src="<?= htmlspecialchars($item['thumbnail_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="card-img-top">
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No content found for your search query.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Content Page</p>
    </footer>
</body>
</html>
