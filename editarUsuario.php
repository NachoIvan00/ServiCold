<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['user_id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    if ($con) {
        // Mostrar la consulta SQL
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id";

        // Ejecutar la consulta SQL
        if (mysqli_query($con, $sql)) {
            echo "<script>
            alert('Usuario modificado con éxito.');
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
