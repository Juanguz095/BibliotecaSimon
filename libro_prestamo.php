<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include("conexion.php");
$mysqli = Conectarse();

$mensaje = '';

// 1) Verificamos que haya un ID válido (si falta, paramos)
if (!isset($_GET['id'])) {
    die("Libro no especificado.");
}
$id_libro = intval($_GET['id']);

// 2) Verificar si el usuario ya tiene el libro prestado
$yaPrestado = false;
if (isset($_SESSION['id_usuario'])) {            // <-- asegúrate de usar este nombre en TODAS partes
    $usuario_id = $_SESSION['id_usuario'];

    // Consulta más robusta: considera NULL, cadena vacía o '0000-00-00'
    $consulta = $mysqli->prepare("
        SELECT 1 
        FROM Prestamos 
        WHERE id_usuario = ? 
          AND id_libro = ? 
          AND (
                estado = 'activo' 
             OR fecha_devolucion IS NULL 
             OR fecha_devolucion = '' 
             OR fecha_devolucion = '0000-00-00'
          )
        LIMIT 1
    ");
    $consulta->bind_param("ii", $usuario_id, $id_libro);
    $consulta->execute();
    $consulta->store_result(); // seguro sin mysqlnd
    $yaPrestado = ($consulta->num_rows > 0);
    $consulta->close();
}

// 3) Procesar el formulario (agregar al carrito)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    if (!isset($_SESSION['carrito_prestamo'])) {
        $_SESSION['carrito_prestamo'] = [];
    }

    $usuario_id = $_SESSION['id_usuario'] ?? null;

    if (!$usuario_id) {
        $mensaje = 'Debes iniciar sesión para agregar libros al carrito.';
    } elseif ($yaPrestado) {
        $mensaje = 'Ya tienes este libro prestado actualmente. Devuélvelo antes de volver a solicitarlo.';
    } elseif (!isset($_SESSION['carrito_prestamo'][$id_libro])) {
        $tiempo = isset($_POST['tiempo_prestamo']) && is_numeric($_POST['tiempo_prestamo'])
                    ? intval($_POST['tiempo_prestamo']) : 7;
        $tiempo = max(1, min(30, $tiempo));
        $_SESSION['carrito_prestamo'][$id_libro] = ['tiempo' => $tiempo];

        $mensaje = "Libro agregado al carrito por $tiempo días.";
        // guardamos flash y hacemos PRG (redirect) para que el mensaje se muestre y evitar resubmit
        $_SESSION['flash'] = $mensaje;
        header("Location: libro_prestamo.php?id=" . $id_libro);
        exit;
    } else {
        $mensaje = 'Este libro ya está en el carrito de préstamo.';
    }

    // Si llegamos aquí hay un mensaje de error o aviso (no éxito), lo guardamos en flash y redirigimos también
    if (!empty($mensaje)) {
        $_SESSION['flash'] = $mensaje;
        header("Location: libro_prestamo.php?id=" . $id_libro);
        exit;
    }
}

// 4) Obtener datos del libro
$stmt = $mysqli->prepare("
    SELECT id_libro, titulo, autor, descripcion, portada, archivo 
    FROM Libros 
    WHERE id_libro = ?
");
$stmt->bind_param("i", $id_libro);
$stmt->execute();
$result = $stmt->get_result();
$libro = $result->fetch_assoc();

if (!$libro) {
    die("El libro no existe.");
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($libro['titulo']); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">
  <!-- header -->
  <header class="bg-[#203474] text-white p-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div>
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
  <!-- Contenedor principal -->
  <div class="max-w-5xl mx-auto py-12 px-6">
    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="max-w-5xl mx-auto mt-6 px-6">
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg shadow text-center">
          <?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl shadow-lg p-8 grid md:grid-cols-2 gap-8">
      
      <!-- Portada -->
      <div>
        <img src="<?php echo $libro['portada']; ?>" 
             alt="Portada de <?php echo htmlspecialchars($libro['titulo']); ?>" 
             class="rounded-xl shadow-md w-full object-cover">
      </div>

    <div class="flex flex-col h-full">
    <div>
        <h1 class="text-4xl font-bold text-[#203474] mb-4"><?php echo htmlspecialchars($libro['titulo']); ?></h1>
        <p class="text-gray-600 mb-2"><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
        <p class="text-gray-700 mb-6"><?php echo nl2br(htmlspecialchars($libro['descripcion'])); ?></p>
    </div>

  <!-- Contenedor de botones al fondo -->
  <div class="mt-auto flex flex-col space-y-2">
      <?php if (isset($_SESSION['nombre'])): ?>

          <!-- Botón Descargar si existe archivo -->
          <?php if (!empty($libro['archivo'])): ?>
              <a href="<?php echo $libro['archivo']; ?>" target="_blank"
              class="w-full text-center px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition">
              Descargar
              </a>
          <?php endif; ?>

          <!-- Si el usuario ya tiene el libro prestado -->
          <?php if ($yaPrestado): ?>
              <p class="text-red-500 font-semibold">
                  Ya tienes este libro prestado actualmente. Devuélvelo antes de volver a solicitarlo.
              </p>
          <?php else: ?>
              <!-- Formulario para agregar al carrito -->
              <form action="libro_prestamo.php?id=<?php echo $libro['id_libro']; ?>" method="POST">
                  <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro']; ?>">
                  <label for="tiempo_prestamo" class="block mb-2 font-semibold">Tiempo de préstamo (días):</label>
                  <input type="number" name="tiempo_prestamo" id="tiempo_prestamo"
                        value="7" min="1" max="30" class="mb-4 px-2 py-1 border rounded">
                  <button type="submit" name="agregar_carrito"
                      class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                      Agregar al carrito de préstamo
                  </button>
              </form>
          <?php endif; ?>

      <?php else: ?>
          <p class="text-gray-500">
              Debes <a href="login.php" class="text-blue-600 underline">iniciar sesión</a>
              para descargar o solicitar préstamos.
          </p>
      <?php endif; ?>
  </div>

    </div>
    </div>
  </div>
  <!-- footer -->
  <footer id="footer" class="bg-[#292c3c] text-white py-10 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center md:items-start justify-between gap-8">

      <!-- parte izquierda -->
      <div class="flex-1 text-left min-w-[220px]">
        <h5 class="font-bold text-lg mb-3">Instituto Simón Bolívar</h5>
        <p class="text-sm">Altura de la Av. Colonial Cuadra 32 - Bellavista - Callao, Perú</p>
        <p class="text-sm">Teléfono: (01) 6147547</p>
        <p class="text-sm">Email: iestbolivar@gmail.com</p>
      </div>

      <!-- parte Centro -->
      <div class="flex-1 text-center">
        <h5 class="font-bold text-lg mb-3">Horario de Atención</h5>
        <p class="text-sm">Lunes a Viernes.</p>
        <p class="text-sm">9:00 a.m. – 3:00 p.m.</p>
      </div>

      <!-- parte derecha -->
      <div class="flex-1 text-center md:text-left md:pl-20">
        <h5 class="font-bold text-lg mb-3 pl-2 inline-block">Síguenos</h5>
        <div class="flex justify-center md:justify-start gap-4">
          <!-- facebook -->
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 224 432" fill="currentColor" class="w-6 h-6">
              <path d="M145 429H66V235H0v-76h66v-56q0-48 27-74t72-26q36 0 59 3v67l-41 1q-22 0-30 9t-8 27v49h76l-10 76h-66v194z"/>
            </svg>
          </a>
          <!-- tikTok -->
          <a href="https://www.tiktok.com/@simonbolivar.pe" target="_blank" aria-label="TikTok" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07z"/>
            </svg>
          </a>
          <!-- instagram -->
          <a href="https://instagram.com/simonbolivar.pe" target="_blank" aria-label="Instagram" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
              <path d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0"/>
            </svg>
          </a>
        </div>
      </div>
    </footer>
          

