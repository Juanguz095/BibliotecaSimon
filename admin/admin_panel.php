<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">
  <div class="w-full max-w-5xl bg-white p-12 rounded-2xl shadow-2xl">
    <h1 class="text-4xl font-extrabold text-[#203474] text-center mb-12">
      Panel de Administración
    </h1>

    <!-- grid de las opciones -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    <!-- boton para volver-->
    <a href="../index.php" 
       class="absolute top-6 left-6 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-gray-400 transition">
      Volver al Inicio
    </a>

      <!-- opcion blog -->
      <a href="admin_blog.php" 
         class="group block bg-gradient-to-r from-[#203474] to-[#162752] p-8 rounded-2xl shadow-lg hover:scale-105 transform transition">
        <div class="flex flex-col items-center text-white">
          <svg class="w-16 h-16 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4h9"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 15h16"></path>
          </svg>
          <h2 class="text-2xl font-bold">Gestionar Blog</h2>
          <p class="text-sm opacity-80 mt-2">Agregar o editar entradas del blog</p>
        </div>
      </a>

      <!-- opcion noticias -->
      <a href="admin_noticias.php" 
          class="group block bg-gradient-to-r from-[#3b82f6] to-[#1d4ed8] p-8 rounded-2xl shadow-lg hover:scale-105 transform transition">
        <div class="flex flex-col items-center text-white">
          <svg class="w-16 h-16 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V7h18v11a2 2 0 01-2 2z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 7V5a2 2 0 012-2h3v4"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7V3h3a2 2 0 012 2v2"></path>
          </svg>
          <h2 class="text-2xl font-bold">Gestionar Noticias</h2>
          <p class="text-sm opacity-80 mt-2">Publicar o actualizar noticias</p>
        </div>
      </a>

      <!-- opcion usuarios -->
      <a href="admin_usuarios.php" 
         class="group block bg-gradient-to-r from-[#16a34a] to-[#065f46] p-8 rounded-2xl shadow-lg hover:scale-105 transform transition">
        <div class="flex flex-col items-center text-white">
          <svg class="w-16 h-16 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5"></path>
            <circle cx="12" cy="10" r="3" stroke-linecap="round" stroke-linejoin="round"></circle>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-1a4 4 0 014-4h4a4 4 0 014 4v1"></path>
          </svg>
          <h2 class="text-2xl font-bold">Gestionar Usuarios</h2>
          <p class="text-sm opacity-80 mt-2">Ver, editar o eliminar usuarios</p>
        </div>
      </a>

    </div>
  </div>
</body>
</html>
