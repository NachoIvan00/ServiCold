<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password_hash'], PASSWORD_DEFAULT); // Encripta la contraseña

    // Verifica la conexión a la base de datos
    if ($con) {
        $sql = "INSERT INTO usuarios (nombre, email, password_hash) VALUES ('$nombre', '$email', '$password')";
        if (mysqli_query($con, $sql)) {
            echo "<script>
            alert('Usuario registrado con éxito.');
            window.location.href = 'aDmINnnisTrADor.html'; //
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        mysqli_close($con);
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>
