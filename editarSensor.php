<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['sensor_id'];
    $nombre = $_POST['nombre'];

    if ($con) {
        // Mostrar la consulta SQL
        $sql = "UPDATE sensores SET nombre='$nombre' WHERE id=$id";
        echo "Consulta SQL: " . $sql;

        // Ejecutar la consulta SQL
        if (mysqli_query($con, $sql)) {
          echo "<script>
            alert('Sensor modificado con éxito.');
            window.location.href = 'aDmINnnisTrADor.html';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
        mysqli_close($con);
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>
