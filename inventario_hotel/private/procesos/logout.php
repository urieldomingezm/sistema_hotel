<?php
session_start();
session_unset();
session_destroy();
header("Location: /inventario_hotel/index.php");
exit();
?>
