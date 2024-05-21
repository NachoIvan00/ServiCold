<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    if ($con) {
        $sql = "DELETE FROM usuarios WHERE nombre = '$nombre'";
        if (mysqli_query($con, $sql)) {
            echo "Usuario eliminado con éxito.";
            exit; // Salir del script para evitar que se muestre más contenido
        } else {
            echo "Error: " . mysqli_error($con);
        }
        mysqli_close($con);
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>
