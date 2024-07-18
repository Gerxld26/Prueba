<?php
include 'db.php'; 
checkAdminSession();

// Manejar la lógica de agregar una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category_name']) && !isset($_POST['edit_category_id'])) {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        $query = $db->prepare('INSERT INTO categories (name) VALUES (?)');
        $query->execute([$category_name]);
        $_SESSION['message'] = "Categoría agregada exitosamente.";
    } else {
        $_SESSION['message'] = "El nombre de la categoría no puede estar vacío.";
    }

    header('Location: dashboard.php');
    exit;
}

// Manejar la lógica de eliminar una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_category_id'])) {
    $delete_category_id = (int)$_POST['delete_category_id'];

    $query = $db->prepare('DELETE FROM categories WHERE id = ?');
    $query->execute([$delete_category_id]);
    $_SESSION['message'] = "Categoría eliminada exitosamente.";

    header('Location: dashboard.php');
    exit;
}

// Manejar la lógica de editar una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category_id'])) {
    $edit_category_id = (int)$_POST['edit_category_id'];
    $edit_category_name = trim($_POST['edit_category_name']);

    if (!empty($edit_category_name)) {
        $query = $db->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $query->execute([$edit_category_name, $edit_category_id]);
        $_SESSION['message'] = "Categoría actualizada exitosamente.";
    } else {
        $_SESSION['message'] = "El nombre de la categoría no puede estar vacío.";
    }

    header('Location: dashboard.php');
    exit;
}

// Manejar la lógica de eliminar contenido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_content_id'])) {
    $delete_content_id = (int)$_POST['delete_content_id'];

    $query = $db->prepare('DELETE FROM content WHERE id = ?');
    $query->execute([$delete_content_id]);
    $_SESSION['message'] = "Contenido eliminado exitosamente.";

    header('Location: dashboard.php');
    exit;
}

// Manejar la lógica de editar contenido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_content_id'])) {
    $edit_content_id = (int)$_POST['edit_content_id'];
    $edit_content_title = trim($_POST['edit_content_title']);
    $edit_content_description = trim($_POST['edit_content_description']);

    if (!empty($edit_content_title) && !empty($edit_content_description)) {
        $query = $db->prepare('UPDATE content SET title = ?, description = ? WHERE id = ?');
        $query->execute([$edit_content_title, $edit_content_description, $edit_content_id]);
        $_SESSION['message'] = "Contenido actualizado exitosamente.";
    } else {
        $_SESSION['message'] = "El título y la descripción no pueden estar vacíos.";
    }

    header('Location: dashboard.php');
    exit;
}

// Obtener todas las categorías
$categoriesQuery = $db->prepare('SELECT * FROM categories');
$categoriesQuery->execute();
$categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

// Filtrar contenido por categoría si se proporciona
$category_filter = isset($_GET['category_filter']) ? (int)$_GET['category_filter'] : 0;

if ($category_filter) {
    $contentQuery = $db->prepare('SELECT * FROM content WHERE category_id = ?');
    $contentQuery->execute([$category_filter]);
} else {
    $contentQuery = $db->prepare('SELECT * FROM content');
    $contentQuery->execute();
}
$content = $contentQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>Admin Dashboard</h1>
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
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <h2>Welcome, Admin!</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <p>Use the navigation to manage content.</p>

        <!-- Formulario para agregar una nueva categoría -->
        <section>
            <h3>Agregar Nueva Categoría</h3>
            <form method="POST" action="dashboard.php">
                <div class="form-group">
                    <label for="category_name">Nombre de la Categoría:</label>
                    <input type="text" id="category_name" name="category_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Categoría</button>
            </form>
        </section>

        <!-- Listado de categorías existentes con opción de eliminar y editar -->
        <section>
            <h3>Categorías Existentes</h3>
            <ul class="list-group mb-4">
                <?php foreach ($categories as $category): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= htmlspecialchars($category['name']) ?></span>
                        <div>
                            <form method="POST" action="dashboard.php" class="d-inline">
                                <input type="hidden" name="delete_category_id" value="<?= $category['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            <form method="POST" action="dashboard.php" class="d-inline">
                                <input type="hidden" name="edit_category_id" value="<?= $category['id'] ?>">
                                <input type="text" name="edit_category_name" value="<?= htmlspecialchars($category['name']) ?>" class="form-control d-inline-block" style="width:auto;" required>
                                <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Filtro por categoría -->
        <section>
            <h3>Filtrar Contenido por Categoría</h3>
            <form method="GET" action="dashboard.php" class="form-inline mb-4">
                <select name="category_filter" class="form-control mr-2">
                    <option value="0">Todas las Categorías</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category_filter == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </section>

        <!-- Listado de contenido con opción de eliminar y editar -->
        <section>
            <h3>Contenido Existente</h3>
            <ul class="list-group">
                <?php foreach ($content as $item): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5><?= htmlspecialchars($item['title']) ?></h5>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                            <div>
                                <form method="POST" action="dashboard.php" class="d-inline">
                                    <input type="hidden" name="delete_content_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                                <form method="POST" action="dashboard.php" class="d-inline">
                                    <input type="hidden" name="edit_content_id" value="<?= $item['id'] ?>">
                                    <input type="text" name="edit_content_title" value="<?= htmlspecialchars($item['title']) ?>" class="form-control d-inline-block" style="width:auto;" required>
                                    <input type="text" name="edit_content_description" value="<?= htmlspecialchars($item['description']) ?>" class="form-control d-inline-block" style="width:auto;" required>
                                    <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
