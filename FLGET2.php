<?php
// Configura las cabeceras de la respuesta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

// Incluye la conexión a la base de datos
include 'conexion.php';

// Inicializa la respuesta como un array vacío
$response = [];

if ($con) {
    // Realiza una consulta de selección para obtener datos de la tabla FL-902
    $consulta = "SELECT nivel_combustible, fecha_actual FROM `FL902` ORDER BY fecha_actual DESC";

    // Ejecuta la consulta
    $resultado = mysqli_query($con, $consulta);

    if ($resultado) {
        // Crear un array para almacenar los datos formateados
        $data = array();

        // Recorre los resultados de la consulta y almacena cada fila en el array de respuesta
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Formatear la fecha en el formato adecuado
            $fila['fecha_actual'] = date("Y-m-d H:i:s", strtotime($fila['fecha_actual']));
            // Agregar la fila al array de datos
            $data[] = $fila;
        }

        // Asignar los datos formateados al array de respuesta
        $response = $data;
    } else {
        // Si hay un error en la consulta, devuelve un mensaje de error
        http_response_code(500); // Establece un código de respuesta HTTP 500 (Error interno del servidor)
        $response = ["error" => "Error al consultar la base de datos"];
    }
} else {
    // Si la conexión a la base de datos falla, devuelve un mensaje de error
    http_response_code(500); // Establece un código de respuesta HTTP 500 (Error interno del servidor)
    $response = ["error" => "Error de conexión a la base de datos"];
}

// Devuelve la respuesta como JSON
echo json_encode($response);
?>
