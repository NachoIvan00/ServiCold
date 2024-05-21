<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    if ($con) {
        $sql = "DELETE FROM sensores WHERE nombre = '$nombre'";
        if (mysqli_query($con, $sql)) {
           echo "Sensor eliminado con éxito.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
        mysqli_close($con);
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>
