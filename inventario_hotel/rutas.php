<?php
// Definir la ruta raíz del proyecto
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');

// Definir rutas para carpetas específicas
define('PRIVATE_PATH', ROOT_PATH.'private/');
define('MODULOS_PATH', ROOT_PATH.'menu/'); // Ruta a menu alumnos, aspirantes y personal
define('TEMPLATES_PATH', PRIVATE_PATH.'plantillas/'); // Ruta a header.php y footer.php
define('CONFIG_PATH', PRIVATE_PATH.'conexion_bd/'); // RUTA DE BD
define('MENU_PATH', PRIVATE_PATH.'menu/'); // RUTA DE MENU
define('PROCESOS_PATH', PRIVATE_PATH.'menu/'); // RUTA DE PROCESOS


// define('MENU_PATH', PRIVATE_PATH.'menu/');
?>


