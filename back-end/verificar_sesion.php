<?php
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['usuario_id'])) {
    // Usuario autenticado
    echo json_encode(["success" => true]);
} else {
    // Usuario no autenticado
    echo json_encode(["error" => "Usuario no autenticado"]);
}
?>
