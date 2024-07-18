<?php
session_start();
include 'db.php'; // Incluir la conexión a la base de datos

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;

$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$contentQuery = $db->prepare("
    SELECT SQL_CALC_FOUND_ROWS * 
    FROM content 
    LIMIT :start, :perPage
");
$contentQuery->bindParam(':start', $start, PDO::PARAM_INT);
$contentQuery->bindParam(':perPage', $perPage, PDO::PARAM_INT);
$contentQuery->execute();
$content = $contentQuery->fetchAll(PDO::FETCH_ASSOC);

$totalQuery = $db->query("SELECT FOUND_ROWS() as total");
$total = $totalQuery->fetch()['total'];

$pages = ceil($total / $perPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Content Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1> FAP FLIXX</h1>
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
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <form class="form-inline ml-auto" action="search.php" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="q" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <section id="content" class="row">
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
        </section>
        <nav id="pagination" class="d-flex justify-content-center">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </main>
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Content Page</p>
    </footer>
</body>
</html>
