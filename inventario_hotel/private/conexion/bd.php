<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno desde .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function conectarBD() {
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $database = $_ENV['DB_NAME'];

    try {
        // Crear conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES 'utf8'");
        
        echo "";
        
        return $conn;
    } catch(PDOException $e) {
        echo "<body style='color: black;'>Error de conexión: " . $e->getMessage() . "</body>";
        return null;
    }
}

$conn = conectarBD();
?>