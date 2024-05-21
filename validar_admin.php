<?php
// Definir la contraseña de administrador
$admin_password = 'admin'; // Cambia esto por la contraseña deseada

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    // Validar la contraseña
    if ($password === $admin_password) {
        // Redirigir a la página de administrador
        header('Location: aDmINnnisTrADor.html');
        exit;
    } else {
        echo 'Contraseña incorrecta. <a href="index.html">Volver</a>';
    }
} else {
    echo 'Método de solicitud no válido.';
}
?>
