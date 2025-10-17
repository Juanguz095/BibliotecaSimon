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
  <!-- header -->
  <header class="bg-[#203474] text-white p-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div><!-- Borre lo que habia aca por que era redundante class="flex items-center gap-4"-->
      <!--logo-->
        <a href="index.php" class="flex items-center gap-4">
          <img src="https://institutobolivar.edu.pe/wp-content/uploads/2025/07/LOGO-OFICIAL-PNG-copia.png" alt="Logo Instituto Simón Bolívar" class="w-12 h-12 bg-white p-1 rounded"/>
          <h1 class="text-lg font-bold">Instituto Simón Bolívar</h1>
        </a>
      </div>
      <!--botones de navegacion-->
      <nav>
        <ul class="flex gap-6 text-sm font-semibold items-center">
            <li>
            <!-- boton Noticias -->
            <a href="noticias.php" class="flex items-center gap-1 hover:underline">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                  viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M7 8h10M7 12h8m-8 4h6M5 6h14a2 2 0 012 2v12a2 2 0 
                        01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
              </svg>
              <p>Noticias</p>
            </a>
          </li>
            <!-- boton Blog -->
            <a href="blog.php" class="flex items-center gap-1 hover:underline">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                  viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 20H5a2 2 0 01-2-2V7h18v11a2 2 0 01-2 2zM5 7V5a2 2 0 012-2h3v4" />
              </svg>
              <p>Blog</p>
            </a>
          </li>
            <!--boton libros-->
            <a href="libros.php" class="flex items-center gap-1 hover:underline">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h9v16H3z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4h9v16h-9z" />
              </svg>
              <p>Libros</p>
            </a>
          </li>
          <li>
            <?php if (isset($_SESSION['nombre'])): ?>
              <!-- Usuario logueado -->
              <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#162752] text-white shadow-md">
                <img src="<?php echo $_SESSION['foto']; ?>" class="w-8 h-8 rounded-full" alt="Foto perfil">
                <span><?php echo $_SESSION['nombre']." ".$_SESSION['apellidoPaterno']; ?></span>
                <a href="logout.php" class="ml-4 text-red-600 hover:underline">Cerrar sesión</a>
              </div>
            <?php else: ?>
              <!-- Botón login (solo si NO hay sesión) -->
              <a href="login.php" 
                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-[#685454] text-white hover:bg-[#162752] shadow-md transition">
                
                <!-- icono -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                    viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.67 0 
                          5.148.88 7.121 2.804M15 11a3 3 0 
                          11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Loguéate</span>
              </a>
            <?php endif; ?>
          </li>
          <li>
            <!-- Carrito de préstamo -->
            <?php if (isset($_SESSION['id_usuario'])): ?>
              <?php 
                $carrito_count = 0;
                if (isset($_SESSION['carrito_prestamo'])) {
                  // Solo cuenta los libros que realmente están en el carrito
                  $carrito_count = count(array_filter($_SESSION['carrito_prestamo']));
                }
              ?>
              <a href="carrito_prestamo.php" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                </svg>
                <span>(<?php echo $carrito_count; ?>)</span>
              </a>
            <?php endif;?>
          </li>
        </ul>
      </nav>
    </div>
  </header>
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
