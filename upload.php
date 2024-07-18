<?php
include 'db.php'; 
checkAdminSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $media_url = trim($_POST['media_url']);
    $category_id = (int)$_POST['category_id'];
    $thumbnail_url = '';

    if (empty($title) || empty($description) || empty($media_url) || empty($category_id)) {
        $_SESSION['message'] = "Todos los campos son obligatorios.";
        header('Location: upload.php');
        exit;
    }

    // Verificar y crear la carpeta de miniaturas si no existe
    $upload_dir = 'thumbnails/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Manejar la subida de la miniatura
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['thumbnail']['tmp_name']);
        $max_size = 2 * 1024 * 1024; // 2 MB

        if (in_array($file_type, $allowed_types) && $_FILES['thumbnail']['size'] <= $max_size) {
            $upload_file = $upload_dir . basename($_FILES['thumbnail']['name']);

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_file)) {
                $thumbnail_url = $upload_file;
            } else {
                $_SESSION['message'] = "Error al subir la miniatura.";
                header('Location: upload.php');
                exit;
            }
        } else {
            $_SESSION['message'] = "Tipo de archivo o tamaño no válido.";
            header('Location: upload.php');
            exit;
        }
    }

    $query = $db->prepare('INSERT INTO content (title, description, media_url, category_id, thumbnail_url) VALUES (?, ?, ?, ?, ?)');
    $query->execute([$title, $description, $media_url, $category_id, $thumbnail_url]);

    $_SESSION['message'] = "Contenido agregado exitosamente.";
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Content</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-3">
        <h1>Upload Content</h1>
        <nav>
            <a href="dashboard.php" class="text-white">Dashboard</a>
            <a href="logout.php" class="text-white">Logout</a>
        </nav>
    </header>
    <main class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <h2>Upload New Content</h2>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="media_url">DoodStream Video URL:</label>
                <input type="url" id="media_url" name="media_url" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <?php
                    $categoriesQuery = $db->prepare('SELECT * FROM categories');
                    $categoriesQuery->execute();
                    $categories = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail:</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control-file" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </main>
</body>
</html>
