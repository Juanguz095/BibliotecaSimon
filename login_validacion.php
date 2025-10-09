<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");
$mysqli = Conectarse();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['correo']);
    $password = trim($_POST['contraseña']);

    // Consulta preparada para evitar inyección SQL
    $sql = "SELECT * FROM Usuarios WHERE correo = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // ⚠️ Si tus contraseñas están en texto plano (como tu tabla), usa:
        if ($usuario['contraseña'] === $password) {
        // 🔐 Si usas contraseñas cifradas, cámbialo a:
        // if (password_verify($password, $usuario['contraseña'])) {

            // Guardar datos en sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellidoPaterno'] = $usuario['apellidoPaterno'];
            $_SESSION['apellidoMaterno'] = $usuario['apellidoMaterno'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['tipo'] = $usuario['tipo'];
            $_SESSION['foto'] = $usuario['foto'];

            // Redirigir al inicio (index.php)
            if ($usuario['tipo'] === 'admin') 
                { header("Location: admin/admin_panel.php"); } 
            else { 
                header("Location: index.php"); } 
            exit();
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ No existe un usuario con ese correo.";
    }
}
?>
