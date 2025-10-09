<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include("conexion.php");
$mysqli = Conectarse();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_libro = $_POST['id_libro'];

// Registrar el préstamo directamente sobre el libro
$stmt = $mysqli->prepare("INSERT INTO Prestamos (fecha_inicio, id_usuario, estado, id_libro, fecha_solicitud) 
                          VALUES (NOW(), ?, 'activo', ?, NOW())");
$stmt->bind_param("ii", $id_usuario, $id_libro);
$stmt->execute();

// Guardar mensaje en la sesión
$_SESSION['flash'] = "Préstamo realizado con éxito.";

// Redirigir al perfil
header("Location: perfil.php");
exit;
