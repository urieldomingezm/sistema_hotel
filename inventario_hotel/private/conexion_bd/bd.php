<?php

function conectarBD() {
    $servername = "db";  // Nombre del servicio en docker-compose.yml
    $username = "root";
    $password = "root";
    $database = "hotel_inventario";

    try {
        // Crear conexión PDO
        $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES 'utf8'");
        
        // Aquí se puede mostrar el contenido de la página sin errores
        echo "";
        
        // Retornar la conexión para ser utilizada en otros lugares si es necesario
        return $conn;
    } catch(PDOException $e) {
        // Si ocurre un error, se captura y muestra el mensaje de error
        echo "<body style='color: black;'>Error de conexión: " . $e->getMessage() . "</body>";
        return null;
    }
}

// Llamada a la función de conexión
$conn = conectarBD();

?>