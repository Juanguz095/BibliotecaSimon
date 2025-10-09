
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center font-sans">

  <!-- fondo -->
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66"
         alt=""
         class="w-full h-full object-cover"/>
    <div class="absolute inset-0 bg-[#162752] bg-opacity-70"></div>
  </div>

  <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

    <!-- lado izquierdo -->
    <div class="flex flex-col items-center justify-center p-10 text-center bg-[#162752] text-white">
      <h1 class="text-4xl font-bold mb-4">Bienvenido de Nuevo</h1>
      <p class="mb-6 max-w-sm">
        Accede a la Biblioteca Digital del Instituto Simón Bolívar para gestionar tus préstamos, buscar libros y mucho más.
      </p>

      <!-- iconos de redes -->
      <div class="flex space-x-4">
        <!-- Fb -->
        <a href="https://www.facebook.com/IESPSIMONBOLIVAR" target="_blank" rel="noopener noreferrer"
           class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 224 432" fill="currentColor" class="w-6 h-6">
            <path d="M145 429H66V235H0v-76h66v-56q0-48 27-74t72-26q36 0 59 3v67l-41 1q-22 0-30 9t-8 27v49h76l-10 76h-66v194z"/>
          </svg>
        </a>

        <!-- Tt -->
        <a href="https://www.tiktok.com/@simonbolivar.pe" target="_blank" aria-label="TikTok"
           class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07z"/>
          </svg>
        </a>

        <!-- ig -->
        <a href="https://instagram.com/simonbolivar.pe" target="_blank" aria-label="Instagram"
           class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#292c3c] hover:bg-[#1e2230] hover:text-white transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z"/>
          </svg>
        </a>
      </div>
    </div>

    <!-- lado derecho -->
    <div class="p-10 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-[#162752] mb-6">Iniciar Sesión</h2>
      <form action="login_validacion.php" method="POST" class="space-y-5">
        <!-- email -->
        <div>
          <label for="correo" class="block text-sm font-medium mb-1">Correo estudiantil/docente</label>
          <input type="text" id="correo" name="correo" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#162752]" />
        </div>

        <!-- contrasena -->
        <div>
          <label for="contraseña" class="block text-sm font-medium mb-1">Contraseña</label>
          <input type="password" id="contraseña" name="contraseña" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#162752]" />
        </div>

        <!-- recordar contrasena -->
        <div class="flex items-center">
          <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-[#162752] border-gray-300 rounded">
          <label for="remember" class="ml-2 text-sm text-gray-600">Recuérdame</label>
        </div>

        <!-- boton -->
        <button type="submit"
          class="w-full bg-[#162752] text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
          Ingresar
        </button>
      </form>

      <!-- links -->
      <div class="mt-4 text-center space-y-2">
        <a href="#" class="text-sm text-[#162752] hover:underline">¿Olvidaste tu contraseña?</a><br>
        <a href="https://institutobolivar.edu.pe/" target="_blank" class="text-sm text-gray-600 hover:underline">Volver al portal principal del Instituto</a>
      </div>
    </div>
  </div>

</body>
</html>
