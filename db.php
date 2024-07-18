<?php
// Mostrar errores de PHP (opcional, puedes quitar estas líneas en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datos de configuración de la base de datos
define('DB_HOST', 'localhost'); // Cambia si tu servidor es diferente
define('DB_NAME', 'fap'); // Nombre de la base de datos
define('DB_USER', 'root'); // Usuario de la base de datos
define('DB_PASS', ''); // Contraseña de la base de datos

// Conexión a la base de datos utilizando PDO
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    // Establecer el modo de error de PDO para usar excepciones
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Mostrar mensaje de error si falla la conexión
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}

// Función para verificar la sesión de administrador
function checkAdminSession() {
    session_start();
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('Location: login.php');
        exit;
    }
}

// Función para iniciar una sesión segura
function secureSessionStart() {
    $session_name = 'secure_session_id';   // Nombre personalizado para la sesión
    $secure = false;                       // Configurar como true si se usa HTTPS
    $httponly = true;                      // Esto detiene JavaScript de poder acceder a la ID de la sesión.

    ini_set('session.use_only_cookies', 1);   // Fuerza a las sesiones a solo usar cookies.
    $cookieParams = session_get_cookie_params(); // Obtiene los parámetros de la cookie actual.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_name($session_name); // Configura el nombre de sesión a el configurado arriba.
    session_start();             // Inicia la sesión PHP.
    session_regenerate_id(true); // Regenera la sesión y elimina la vieja.
}
?>
