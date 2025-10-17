<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
include("conexion.php");
$mysqli = Conectarse();

// Agregar libro al carrito de préstamo
if (isset($_GET['agregar'])) {
    $id_libro = (int)$_GET['agregar'];
    if (!isset($_SESSION['carrito_prestamo'][$id_libro])) {
        $_SESSION['carrito_prestamo'][$id_libro] = [
            'tiempo' => 7 // tiempo inicial de préstamo en días
        ];
    }
    header('Location: libros.php');
    exit;
}

// Obtener todos los libros
$result = $mysqli->query("SELECT * FROM Libros");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administración de empresas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

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

  <div class="flex-1">

    <!-- banenr -->
    <section class="relative bg-gray-800 text-white py-28 mt-6 mx-4 rounded-2xl overflow-hidden">
      <img src="https://picsum.photos/1200/500" alt="Banner Desarrollo de Sistemas"
        class="absolute inset-0 w-full h-full object-cover opacity-60">

      <div class="relative z-10 text-center max-w-3xl mx-auto">
        <h1 class="text-5xl font-bold mb-4">Administración de Empresas</h1>
        <p class="text-lg">Explora las áreas de Administración de Empresas y encuentra los libros que necesitas.</p>
      </div>
    </section>

    <!-- subcategorias -->
    <section
      class="relative py-10 px-6 bg-gradient-to-b from-[#f8fafc] via-[#eef2ff] to-[#e0e7ff] overflow-hidden mt-1">
      <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-64 h-64 bg-[#203474]/10 rounded-full blur-3xl animate-pulse"></div>
        <div
          class="absolute bottom-20 right-20 w-72 h-72 bg-[#4f6bbf]/10 rounded-full blur-2xl animate-pulse delay-200">
        </div>
      </div>

      <!-- cards -->
      <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-3">
        <?php //esto muestra todos los programas
          $result = $mysqli->query("SELECT nombre, descripcionBreve, portada ,id_programa
                                    FROM Programas");

          while($row = $result->fetch_assoc()){
            echo "
              <div class='group bg-white/80 backdrop-blur-md rounded-3xl shadow-xl overflow-hidden transform hover:-translate-y-3 hover:scale-105 transition duration-500 hover:shadow-2xl'>
                <a href='programas_libros.php?id={$row['id_programa']}'>
                    <img src='{$row['portada']}' class='w-full h-48 object-cover group-hover:scale-110 transition duration-500'>
                    <div class='p-8 flex flex-col h-full'>
                      <h4 class='text-2xl font-bold text-[#203474] mb-3 group-hover:text-[#4f6bbf] transition'>{$row['nombre']}</h4>
                      <p class='text-gray-600 flex-1 mb-4'>{$row['descripcionBreve']}</p>
                    </div>
                </a>
              </div>
              
              ";
          }
          ?>
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
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 224 432" fill="currentColor"
              class="w-6 h-6">
              <path
                d="M145 429H66V235H0v-76h66v-56q0-48 27-74t72-26q36 0 59 3v67l-41 1q-22 0-30 9t-8 27v49h76l-10 76h-66v194z" />
            </svg>
          </a>
          <!-- tikTok -->
          <a href="https://www.tiktok.com/@simonbolivar.pe" target="_blank" aria-label="TikTok"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
              class="w-6 h-6">
              <path
                d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07z" />
            </svg>
          </a>
          <!-- instagram -->
          <a href="https://instagram.com/simonbolivar.pe" target="_blank" aria-label="Instagram"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
              class="w-6 h-6">
              <path
                d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>