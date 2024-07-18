<?php
include 'db.php'; // Incluir la conexión a la base de datos
secureSessionStart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Buscar el usuario en la base de datos
    $query = $db->prepare('SELECT * FROM users WHERE username = ?');
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verificar la contraseña
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['message'] = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <h2>Admin Login</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </main>
</body>
</html>
