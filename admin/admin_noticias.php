<?php
include("../conexion.php");//colocarle los dos puntitos mas el / en las paguinas del admin
$mysqli = Conectarse();

// Guardar nueva noticia
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["titulo"])) {
    $titulo = $mysqli->real_escape_string($_POST["titulo"]);
    $contenido = $mysqli->real_escape_string($_POST["contenido"]);
    $imagen = $mysqli->real_escape_string($_POST["imagen"]);
    $estado = $_POST["estado"];

    $sql = "INSERT INTO Noticias (titulo, contenido, imagen, estado) 
            VALUES ('$titulo', '$contenido', '$imagen', '$estado')";
    if ($mysqli->query($sql)) {
        $mensaje = "<p class='bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-center'>Noticia agregada correctamente ^^</p>";
    } else {
        $mensaje = "<p class='bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center'>Error: " . $mysqli->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin - Noticias</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- CKEditor 5 -->
  <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</head>
<body class="bg-gray-100 p-8 font-sans">
  <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-[#203474] mb-6">Agregar Noticia</h2>

    <!-- Mostrar mensaje -->
    <?php if (!empty($mensaje)) echo $mensaje; ?>

    <form method="POST" class="space-y-6">
      <div>
        <label class="block font-semibold mb-1">Título</label>
        <input type="text" name="titulo" required 
               class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-[#203474] outline-none">
      </div>

      <div>
        <label class="block font-semibold mb-1">Contenido</label>
        <textarea name="contenido" rows="10" required 
                  class="w-full border px-4 py-2 rounded-lg"></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1">URL Imagen</label>
        <input type="text" name="imagen" placeholder="https://picsum.photos/800/400" 
               class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-[#203474] outline-none">
      </div>

      <div>
        <label class="block font-semibold mb-1">Estado</label>
        <select name="estado" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-[#203474] outline-none">
          <option value="publicado">Publicado</option>
          <option value="borrador">Borrador</option>
        </select>
      </div>

      <div class="flex justify-between">
        <a href="admin.php" 
           class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
          ⬅ Volver al Panel
        </a>
        <button type="submit" 
                class="bg-[#203474] text-white px-6 py-2 rounded-lg hover:bg-[#162752] transition">
          Guardar Noticia
        </button>
      </div>
    </form>
  </div>

  <!-- Activar CKEditor -->
  <script>
    ClassicEditor
      .create(document.querySelector('textarea[name=contenido]'))
      .catch(error => {
        console.error(error);
      });
  </script>
</body>
</html>
