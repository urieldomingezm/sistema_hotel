<?php

define('ROOT_PATH', __DIR__ . '/');

// Rutas a carpetas públicas
define('PUBLIC_PATH', ROOT_PATH. 'public/');

// Rutas a carpetas privadas
define('PRIVATE_PATH', ROOT_PATH . 'private/');
define('TEMPLATES_PATH', PRIVATE_PATH . 'plantillas/'); 
define('CONFIG_PATH', PRIVATE_PATH . 'conexion/');
define('MENU_PATH', PRIVATE_PATH . 'menu/');  
define('MODALES_PATH', PRIVATE_PATH . 'modales/');
define('PROCESOS_PATH', PRIVATE_PATH . 'procesos/');

// Rutas a carpetas de gestion de inventario
define('GESTION_PATH', ROOT_PATH . 'gestion/');
// define('MI_CUENTA_PATH', GESTION_PATH . 'mi_cuenta/');
// define('ACCIONES_PATH', GESTION_PATH . 'acciones/');
// AUN EN PRUEBA
?>