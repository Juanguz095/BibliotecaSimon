<?php
function Conectarse()
{
   $mysqli = new mysqli("localhost", "root", "", "BibliotecaDB");
   if ($mysqli->connect_error) {
       echo "Error en la conexión de la base de datos: " . $mysqli->connect_error;
       exit();
   }
   $mysqli->query("SET NAMES 'utf8'");
   return $mysqli;
}
?>
