<?php
  include("conexion.php");
  $mysqli = Conectarse();
  //esto es para obtener el nombre y la foto del usuario que haya iniciado sesion
  $_SESSION['id_usuario'] = $row['id_usuario'];
  $_SESSION['nombres'] = $row['nombres'];
  $_SESSION['foto'] = $row['foto'];
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Biblioteca</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
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
                <a href="perfil.php">
                  <img src="<?php echo $_SESSION['foto']; ?>" class="w-8 h-8 rounded-full" alt="Foto perfil">
                </a>
                <a href="perfil.php">
                  <span><?php echo $_SESSION['nombre']." ".$_SESSION['apellidoPaterno']; ?></span>
                </a>
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

  <!-- panel de bienvenida -->
  <section class="relative bg-cover bg-center text-white text-center min-h-[440px] flex items-center justify-center" 
    style="background-image: url('https://picsum.photos/1400/600?random=10');">
    
    <!-- cuadro con buscador -->
    <div class="bg-black/40 p-8 max-w-3xl mx-auto rounded">
      <h2 class="text-3xl font-extrabold mb-2 drop-shadow">Bienvenido a la Biblioteca del Instituto Simón Bolívar</h2>
      <p class="mb-6 text-white/90">Encuentra y consulta tus libros de manera rápida y sencilla.</p>

      <!-- buscador -->
      <div class="max-w-3xl mx-auto my-10">
        <form class="flex items-center gap-2 relative" onsubmit="return false;">
          <input 
            id="buscador" 
            type="search" 
            placeholder="Buscar libros por título, autor o categoría..." 
            class="flex-1 px-4 py-3 rounded-full text-sm text-gray-900 shadow-md"
            autocomplete="off"
          />
          <button 
            type="button" 
            onclick="buscarLibros()" 
            class="bg-[#203474] text-white px-5 py-2 rounded-full font-bold shadow-md hover:bg-[#162752] transition">
            Buscar
          </button>
        </form>
      </div>
      <div id="resultados-busqueda" 
          class="mt-4 max-h-64 overflow-y-auto bg-white rounded-lg shadow-md p-4 text-left hidden">
      </div>
    </div>
  </section>


  <!-- noticias -->
  <section id="noticias" class="container mx-auto py-12 px-12 relative">
      <h3 class="text-4xl font-bold text-[#203474] mb-6">Noticias</h3>

      <!-- contenedor con scroll -->
      <div id="noticias-container" class="flex overflow-x-auto gap-6 snap-x snap-mandatory scroll-smooth no-scrollbar">
        <?php
          $result = $mysqli->query("SELECT titulo, contenido, imagen, fecha_publicacion 
                                    FROM Noticias 
                                    ORDER BY fecha_publicacion DESC 
                                    LIMIT 10");

          while($row = $result->fetch_assoc()){
            echo "
              <article class='min-w-[33.3%] bg-white rounded-lg shadow-md overflow-hidden flex flex-col snap-start'>
                <img src='{$row['imagen']}' class='w-full h-44 object-cover' />
                <div class='p-4'>
                  <h4 class='font-semibold text-xl'>{$row['titulo']}</h4>
                  <p class='text-lg break-words'>".substr($row['contenido'],0,120)."...</p>
                  <span class='text-sm text-gray-500 block mt-2'>Publicado: {$row['fecha_publicacion']}</span>
                </div>
              </article>
            ";
          }
        ?>
      </div>

      <!-- flechas -->
      <button onclick="moverNoticias(-1)"
        class="absolute top-1/2 left-0 -translate-y-1/2 bg-[#203474] text-white p-3 rounded-full shadow-md hover:bg-[#162752]">
        &lt;
      </button>
      <button onclick="moverNoticias(1)"
        class="absolute top-1/2 right-0 -translate-y-1/2 bg-[#203474] text-white p-3 rounded-full shadow-md hover:bg-[#162752]">
        &gt;
      </button>
  </section>

  <!-- esto es para que no aparesca la barra de scroll -->
  <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  </style>
  <!-- este script se encarga de mover el carrusel,  -->
  <script>
    function moverNoticias(direccion) {
      const container = document.getElementById('noticias-container');
      const articulosWidth = container.querySelector('article').offsetWidth + 24; // ancho tarjeta + gap
      container.scrollBy({ left: direccion * articulosWidth * 3, behavior: 'smooth' });
    }
  </script>

  <!-- carreras -->
  <section id="carreras" class="relative py-24 px-6 bg-gradient-to-b from-[#f8fafc] via-[#eef2ff] to-[#e0e7ff] overflow-hidden">
    <!-- fondo -->
    <div class="absolute inset-0">
      <div class="absolute top-10 left-10 w-64 h-64 bg-[#203474]/10 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-20 right-20 w-72 h-72 bg-[#4f6bbf]/10 rounded-full blur-2xl animate-pulse delay-200"></div>
    </div>

    <div class="relative max-w-7xl mx-auto text-center">
      <h3 class="text-4xl md:text-5xl font-extrabold text-[#203474] mb-6 drop-shadow-lg">
        Elige un libro según tu carrera
      </h3>
      <p class="max-w-3xl mx-auto text-lg text-gray-700 mb-16">
        Explora nuestra colección organizada por carreras. Encuentra los libros que mejor se adaptan a tu formación académica 
        y potencia tus conocimientos con recursos seleccionados especialmente para ti.
      </p>

      <!-- grid -->
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
  </section>


  <!-- blog -->
  <section id="blog" class="py-24 px-6 bg-gradient-to-b from-white via-[#f1f5f9] to-[#e2e8f0]">
    <div class="max-w-7xl mx-auto">
      <h3 class="text-5xl font-extrabold text-center text-[#203474] mb-20 relative">
        Blog de la Biblioteca
        <span class="block w-20 h-1 bg-[#203474] mx-auto mt-4 rounded-full"></span>
      </h3>

      <div class="grid gap-16 lg:grid-cols-2">
        <?php
        //consulta
        $sql = "SELECT id_blog, titulo, contenido, imagen, fecha_publicacion 
                FROM Blog 
                ORDER BY fecha_publicacion DESC LIMIT 6";
        $result = $mysqli->query($sql);

        // esto muestra loas articulos del blog
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <article class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transform hover:-rotate-1 hover:-translate-y-2 transition duration-500">
                  <div class="overflow-hidden rounded-t-3xl">
                    <img src="' . htmlspecialchars($row["imagen"]) . '" alt="' . htmlspecialchars($row["titulo"]) . '" 
                        class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">
                  </div>
                  <div class="p-8">
                    <h4 class="text-2xl font-bold text-[#203474] mb-3 relative after:block after:w-16 after:h-1 after:bg-[#203474] after:mt-2">'
                        . htmlspecialchars($row["titulo"]) .
                    '</h4>
                    <p class="text-gray-600 mb-6 leading-relaxed">'
                        . substr(strip_tags($row["contenido"]), 0, 200) . '...
                    </p>
                    <a href="articulo_blog.php?id=' . $row['id_blog'] . '" 
                      class="inline-block text-sm font-semibold text-[#203474] hover:text-[#4f6bbf] transition">
                      Leer más →
                    </a>
                  </div>
                </article>';
            }
        } else {
          echo "<p class='text-center text-gray-500'>No hay artículos.</p>";
        }

        $mysqli->close();
        ?>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="bg-white py-20 px-6 max-w-4xl mx-auto">
    <h3 class="text-3xl font-bold text-blue-900 mb-12 text-center">Preguntas frecuentes</h3>
    <div class="space-y-6 text-gray-700">

      <!-- 1era pregunta -->
      <details class="border border-gray-300 rounded p-4">
        <summary class="cursor-pointer font-semibold text-blue-900 text-lg">¿Cómo puedo registrarme?</summary>
        <p class="mt-2">Solo haz clic en "Registrarse" en el menú superior y completa el formulario con tus datos.</p>
      </details>

      <!-- 2da pregunta -->
      <details class="border border-gray-300 rounded p-4">
        <summary class="cursor-pointer font-semibold text-blue-900 text-lg">¿Puedo pedir un libro prestado en línea?</summary>
        <p class="mt-2">Sí, puedes solicitar préstamos desde tu perfil y luego recoger el libro en la biblioteca física.</p>
      </details>

      <!-- 3ra pregunta -->
      <details class="border border-gray-300 rounded p-4">
        <summary class="cursor-pointer font-semibold text-blue-900 text-lg">¿Qué pasa si atraso la devolución?</summary>
        <p class="mt-2">Se generan multas que puedes revisar y pagar desde tu perfil para evitar bloqueos.</p>
      </details>

      <!-- 4ta pregunta -->
      <details class="border border-gray-300 rounded p-4">
        <summary class="cursor-pointer font-semibold text-blue-900 text-lg">¿Quién administra la biblioteca?</summary>
        <p class="mt-2">Los administradores autorizados gestionan libros, usuarios y préstamos para mantener el sistema actualizado.</p>
      </details>

    </div>
  </section>
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
              <path d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>
<script>
const buscador = document.getElementById('buscador');
const resultadosDiv = document.getElementById('resultados-busqueda');

// Escuchar cada vez que el usuario escribe
buscador.addEventListener('input', function() {
    const query = this.value.trim();

    if (query === '') {
        resultadosDiv.innerHTML = '';
        resultadosDiv.classList.add('hidden');
        return;
    }

    // Buscar mientras escribe
    fetch('buscar_libros.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            resultadosDiv.innerHTML = data.trim() || '<p class="text-gray-500">No se encontraron libros.</p>';
            resultadosDiv.classList.remove('hidden');
        })
        .catch(error => console.error('Error:', error));
});
</script>


</body>
</html>

