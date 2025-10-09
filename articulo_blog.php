<?php
include("conexion.php");
$mysqli = Conectarse();
?>

<?php
// obtener id del libro a mostrar, si no ahi id devuelve 0
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$result = $mysqli->query("SELECT * FROM Blog WHERE id_blog=$id");
$entrada = $result->fetch_assoc();

// si no hay ninguna entrada Location lo regresa a index.php
if (!$entrada) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($entrada['titulo']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="max-w-4xl mx-auto my-12 bg-white p-10 rounded-3xl shadow-lg">
    <!-- titulo -->
    <h1 class="text-4xl font-extrabold text-[#203474] mb-6">
      <?= htmlspecialchars($entrada['titulo']) ?>
    </h1>

    <!-- fecha -->
    <p class="text-gray-500 text-sm mb-10">
      📅 Publicado el: <?= $entrada['fecha_publicacion'] ?>
    </p>

    <!-- contenido-->
    <div class="contenido-blog prose prose-lg max-w-none">
      <?= $entrada['contenido'] ?>
    </div>

    <!-- boton para regresar -->
    <div class="mt-10 text-right">
      <a href="index.php" 
         class="bg-[#203474] text-white px-6 py-2 rounded-full shadow hover:bg-[#4f6bbf] transition">
        ← Regresar
      </a>
    </div>
  </div>
</body>
</html>
