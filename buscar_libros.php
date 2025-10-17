<?php
include("conexion.php");
$mysqli = Conectarse();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '') {
    echo '';
    exit;
}

// Buscar libros
$stmt = $mysqli->prepare("SELECT id_libro, titulo, autor, portada FROM Libros 
                          WHERE titulo LIKE CONCAT('%', ?, '%') OR autor LIKE CONCAT('%', ?, '%') LIMIT 8");
$stmt->bind_param("ss", $q, $q);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p class="text-gray-500 text-sm text-center">No se encontraron libros.</p>';
    exit;
}

// Mostrar resultados compactos
while ($libro = $result->fetch_assoc()) {
    echo "
    <a href='libro_prestamo.php?id={$libro['id_libro']}' 
       class='flex items-center gap-3 p-2 hover:bg-gray-100 rounded-lg transition'>
        <img src='{$libro['portada']}' alt='Portada' class='w-12 h-16 object-cover rounded shadow-sm'>
        <div class='flex flex-col'>
            <span class='font-semibold text-gray-800 text-sm'>{$libro['titulo']}</span>
            <span class='text-gray-500 text-xs'>{$libro['autor']}</span>
        </div>
    </a>
    ";
}
?>
