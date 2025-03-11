<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inventario_hotel/rutas.php');
require_once(CONFIG_PATH . 'bd.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Habilita CORS si accedes desde otro dominio

$conn = conectarBD(); // Llamamos la función para obtener la conexión

if (!$conn) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
    exit;
}

$datos = [];

// Equipos por categoría
$sqlEquipos = "SELECT categorias.nombre AS categoria, COUNT(equipos.id) AS total 
               FROM equipos 
               JOIN categorias ON equipos.categoria_id = categorias.id 
               GROUP BY categorias.nombre";
$stmt = $conn->prepare($sqlEquipos);
$stmt->execute();
$datos['equipos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Equipos por ubicación
$sqlUbicaciones = "SELECT ubicaciones.nombre AS ubicacion, COUNT(equipos.id) AS total 
                   FROM equipos 
                   JOIN ubicaciones ON equipos.ubicacion_id = ubicaciones.id 
                   GROUP BY ubicaciones.nombre";
$stmt = $conn->prepare($sqlUbicaciones);
$stmt->execute();
$datos['ubicaciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Estados de equipos
$sqlEstados = "SELECT estado, COUNT(id) AS total FROM equipos GROUP BY estado";
$stmt = $conn->prepare($sqlEstados);
$stmt->execute();
$datos['estados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Movimientos por tipo
$sqlMovimientos = "SELECT tipo, COUNT(id) AS total FROM movimientos GROUP BY tipo";
$stmt = $conn->prepare($sqlMovimientos);
$stmt->execute();
$datos['movimientos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);

?>
