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

// Préstamos activos
$sql_activos = "SELECT P.id_prestamo, L.titulo, P.fecha_inicio, P.fecha_devolucion
                FROM Prestamos P
                JOIN Libros L ON P.id_libro = L.id_libro
                WHERE P.id_usuario = ? AND P.estado = 'activo'";
$stmt = $mysqli->prepare($sql_activos);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$activos = $stmt->get_result();

// Préstamos anteriores
$sql_anteriores = "SELECT P.id_prestamo, L.titulo, P.fecha_inicio, P.fecha_devolucion
                   FROM Prestamos P
                   JOIN Libros L ON P.id_libro = L.id_libro
                   WHERE P.id_usuario = ? AND P.estado = 'devuelto'";
$stmt = $mysqli->prepare($sql_anteriores);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$anteriores = $stmt->get_result();

// Multas
$sql_multas = "SELECT id_multa, monto, motivo, fecha FROM Multas WHERE id_usuario = ?";
$stmt = $mysqli->prepare($sql_multas);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$multas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="container mx-auto px-6 py-10">
    <h1 class="text-4xl font-bold text-[#203474] mb-6">Mi Perfil</h1>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="mb-4 px-4 py-3 rounded bg-green-100 border border-green-300 text-green-800 font-semibold">
            <?php echo $_SESSION['flash']; ?>
        </div>
        <?php unset($_SESSION['flash']); // Eliminar mensaje después de mostrarlo ?>
    <?php endif; ?>
    <!-- Préstamos Activos -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-2xl font-semibold text-blue-700 mb-4">Préstamos Activos</h2>
      <?php if ($activos->num_rows > 0): ?>
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-blue-100">
              <th class="border px-4 py-2">Título</th>
              <th class="border px-4 py-2">Fecha Inicio</th>
              <th class="border px-4 py-2">Fecha Devolución</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $activos->fetch_assoc()): ?>
              <tr>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['fecha_inicio']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['fecha_devolucion'] ?? 'Pendiente'); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-gray-600">No tienes préstamos activos.</p>
      <?php endif; ?>
    </div>

    <!-- Préstamos Anteriores -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 class="text-2xl font-semibold text-green-700 mb-4">Préstamos Anteriores</h2>
      <?php if ($anteriores->num_rows > 0): ?>
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-green-100">
              <th class="border px-4 py-2">Título</th>
              <th class="border px-4 py-2">Fecha Inicio</th>
              <th class="border px-4 py-2">Fecha Devolución</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $anteriores->fetch_assoc()): ?>
              <tr>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['fecha_inicio']); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['fecha_devolucion']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-gray-600">No tienes préstamos anteriores.</p>
      <?php endif; ?>
    </div>

    <!-- Multas -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-semibold text-red-700 mb-4">Multas</h2>
      <?php if ($multas->num_rows > 0): ?>
        <table class="w-full border-collapse">
          <thead>
            <tr class="bg-red-100">
              <th class="border px-4 py-2">Motivo</th>
              <th class="border px-4 py-2">Monto</th>
              <th class="border px-4 py-2">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $multas->fetch_assoc()): ?>
              <tr>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['motivo']); ?></td>
                <td class="border px-4 py-2">S/ <?php echo number_format($row['monto'], 2); ?></td>
                <td class="border px-4 py-2"><?php echo htmlspecialchars($row['fecha']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-gray-600">No tienes multas registradas.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
