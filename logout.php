<?php
session_start();
session_destroy();
header('Location: login.php'); // Redirige a la página principal después de cerrar sesión
?>
