<?php
    include("../conexion.php");
    $mysqli = Conectarse();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mensaje = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo = trim($_POST['titulo'] ?? '');
        $contenido = trim($_POST['contenido'] ?? '');
        $mensaje = "";

        if ($titulo !== "" && isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $directorioImgs = __DIR__ . "/../img/noticias/";
            if (!is_dir($directorioImgs)) {
                mkdir($directorioImgs, 0777, true);
            }

            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImg = "noticia_" . uniqid() . "." . strtolower($ext);

            $destAbs = $directorioImgs . $nombreImg;
            $destRel = "img/noticias/" . $nombreImg;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destAbs)) {
                $stmt = $mysqli->prepare("INSERT INTO Noticias (titulo, contenido, imagen) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $titulo, $contenido, $destRel);
                if ($stmt->execute()) {
                    $mensaje = "<div style='color:green'>Entrada agregada correctamente ^^ </div>";
                } else {
                    $mensaje = "<div style='color:red'>Error BD: " . $mysqli->error . "</div>";
                }
                $stmt->close();
            } else {
                $mensaje = "<div style='color:red'>Error al mover la imagen.</div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin - Noticias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-4xl bg-white p-10 rounded-2xl shadow-2xl">
        <h1 class="text-4xl font-extrabold text-[#203474] text-center mb-10">Agregar noticia</h1>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block font-semibold mb-2 text-gray-700">Título</label>
                <input type="text" name="titulo" required class="w-full border px-4 py-2 rounded-lg">
            </div>

            <div>
                <label class="block font-semibold mb-2 text-gray-700">Contenido</label>
                <textarea name="contenido" rows="8" class="w-full border px-4 py-2 rounded-lg"></textarea>
            </div>

            <div>
                <label class="block font-semibold mb-2 text-gray-700">Imagen</label>
                <input type="file" name="imagen" accept="image/*" required class="w-full border px-4 py-2 rounded-lg">
            </div>

            <div class="flex justify-between items-center">

                <div>
                    <a href="admin_panel.php" class=" bg-[#e12424] text-white px-6 py-2 rounded-lg hover:bg-gray-400 transition">Volver al panel</a>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-[#203474] text-white px-6 py-2 rounded-lg">Guardar Entrada</button>
                </div>

            </div>
            
        </form>
    </div>

    <script>
    ClassicEditor.create(document.querySelector('textarea[name=contenido]')).catch(console.error);
    </script>
</body>

</html>