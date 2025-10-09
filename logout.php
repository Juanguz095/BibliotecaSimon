<?php
session_start();
session_destroy();

// Guardar la página desde la que vino el usuario
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// Redirigir a esa página
header("Location: $redirect");
exit();
?>