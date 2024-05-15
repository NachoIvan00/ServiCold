<?php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Verifica que los campos no sean nulos
    if (!$nombre || !$email || !$password) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Verifica que el correo electrónico sea válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Correo electrónico no válido.";
        exit;
    }

    // Verifica si el correo electrónico ya está en uso
    $stmt = mysqli_prepare($con, "SELECT id FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "El correo electrónico ya está en uso.";
        exit;
    }

    // Hashea la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Inserta el nuevo usuario en la base de datos
    $stmt = mysqli_prepare($con, "INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sss', $nombre, $email, $passwordHash);
    mysqli_stmt_execute($stmt);

    // Verifica si la consulta fue exitosa
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar usuario";
    }

    // Cierra la declaración preparada
    mysqli_stmt_close($stmt);
}
?>
