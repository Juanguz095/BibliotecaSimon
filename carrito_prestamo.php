<?php
session_start();
include("conexion.php");
$mysqli = Conectarse();

if (!isset($_SESSION['carrito_prestamo'])) $_SESSION['carrito_prestamo'] = [];

// Quitar libro
if (isset($_GET['quitar'])) {
    unset($_SESSION['carrito_prestamo'][$_GET['quitar']]);
    header("Location: carrito_prestamo.php");
    exit;
}

// Actualizar tiempos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
  foreach ($_POST['tiempo'] as $id => $dias) {
    $dias = max(1, (int)$dias); // Asegura que sea al menos 1
    $_SESSION['carrito_prestamo'][$id]['tiempo'] = $dias;
  }
}

// Confirmar préstamo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
  $usuario_id = $_SESSION['id_usuario'] ?? null;
  $libros_prestados = [];
  if ($usuario_id) {
    foreach ($_SESSION['carrito_prestamo'] as $id_libro => $info) {
      // Verificar si el usuario ya tiene el libro prestado y no lo ha devuelto
      $verif = $mysqli->query("SELECT 1 FROM Prestamos WHERE id_usuario = $usuario_id AND id_libro = $id_libro AND fecha_devolucion IS NULL LIMIT 1");
      if ($verif && $verif->num_rows > 0) {
        $libros_prestados[] = $id_libro;
        continue;
      }
      $dias = isset($info['tiempo']) && is_numeric($info['tiempo']) ? intval($info['tiempo']) : 1;
      if ($dias < 1) $dias = 1; // mínimo 1 día
      $fecha_inicio = date('Y-m-d');
      $fecha_devolucion = date('Y-m-d', strtotime("+$dias days", strtotime($fecha_inicio)));
      $fecha_solicitud = date('Y-m-d H:i:s');
      $estado = 'activo';
      $sql = "INSERT INTO Prestamos (fecha_inicio, fecha_devolucion, id_usuario, estado, fecha_solicitud, id_libro) VALUES ('$fecha_inicio', '$fecha_devolucion', $usuario_id, '$estado', '$fecha_solicitud', $id_libro)";
      if (!$mysqli->query($sql)) {
        $mensaje = 'Error al registrar el préstamo: ' . $mysqli->error . '<br>SQL: ' . $sql;
        break;
      }
    }
    $_SESSION['carrito_prestamo'] = [];
    if (empty($mensaje)) {
      if ($libros_prestados) {
        $mensaje = "¡Préstamo realizado! Algunos libros ya estaban prestados y no se volvieron a prestar.";
      } else {
        $mensaje = "¡Préstamo realizado con éxito!";
      }
    }
  } else {
    $mensaje = "Debes iniciar sesión para realizar el préstamo.";
  }
}

// Obtener libros
$libros = [];
if ($_SESSION['carrito_prestamo']) {
    $ids = implode(',', array_keys($_SESSION['carrito_prestamo']));
    $res = $mysqli->query("SELECT * FROM Libros WHERE id_libro IN ($ids)");
    while ($row = $res->fetch_assoc()) $libros[$row['id_libro']] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Préstamo</title>
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
        </ul>
      </nav>
    </div>
  </header>
  <div class="max-w-5xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-[#203474] mb-6">📚 Carrito de Préstamo</h1>

    <?php if (!empty($mensaje)): ?>
      <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg shadow"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <?php if (empty($_SESSION['carrito_prestamo'])): ?>
      <p class="text-gray-600 text-lg">No hay libros en el carrito.</p>
      <a href="libros.php" class="text-blue-600 underline">Volver a libros</a>
    <?php else: ?>
      <form method="POST" class="bg-white p-6 rounded-2xl shadow-lg">
        <table class="w-full border-collapse mb-4">
          <thead class="bg-[#203474] text-white">
            <tr>
              <th class="p-3 text-left">Título</th>
              <th class="p-3 text-left">Autor</th>
              <th class="p-3 text-center">Días</th>
              <th class="p-3 text-center">Acción</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($_SESSION['carrito_prestamo'] as $id => $info): ?>
            <?php
            // Verifica si el usuario ya tiene el libro prestado y no lo ha devuelto
            $yaPrestado = false;
            if (isset($_SESSION['usuario_id'])) {
                $uid = $_SESSION['usuario_id'];
                $verif = $mysqli->query("SELECT 1 FROM Prestamos WHERE id_usuario = $uid AND id_libro = $id AND fecha_devolucion IS NULL LIMIT 1");
                if ($verif && $verif->num_rows > 0) {
                    $yaPrestado = true;
                }
            }
            ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="p-3"><?php echo htmlspecialchars($libros[$id]['titulo']); ?></td>
              <td class="p-3"><?php echo htmlspecialchars($libros[$id]['autor']); ?></td>
              <td class="p-3 text-center">
                <input type="number" name="tiempo[<?php echo $id; ?>]" 
                       value="<?php echo $info['tiempo']; ?>" 
                       min="1" max="30" class="border rounded p-1 w-16 text-center" <?php echo $yaPrestado ? 'disabled' : ''; ?>>
              </td>
              <td class="p-3 text-center">
                <?php if ($yaPrestado): ?>
                  <span class="text-gray-500">Ya prestado</span>
                <?php else: ?>
                  <a href="?quitar=<?php echo $id; ?>" class="text-red-600 hover:underline">Quitar</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>

        <div class="flex justify-end gap-3">
      <button name="actualizar" type="submit" class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Actualizar</button>
      <button name="confirmar" type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Confirmar Préstamo</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</body>

</html>
