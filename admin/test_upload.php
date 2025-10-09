<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
?>
<!DOCTYPE html>
<html>
<body>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="titulo" placeholder="Título"><br><br>
    <textarea name="contenido"></textarea><br><br>
    <input type="file" name="imagen"><br><br>
    <button type="submit">Enviar</button>
  </form>
</body>
</html>
