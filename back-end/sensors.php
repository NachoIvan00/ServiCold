<?php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    // Consulta la tabla de permisos para obtener las tablas a las que el usuario tiene acceso
    $stmt = mysqli_prepare($con, "SELECT tabla FROM permisos WHERE usuario_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Crea un array para almacenar las tablas a las que el usuario tiene acceso
    $tablas_acceso = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tablas_acceso[] = $row['tabla'];
    }

    // Cierra la declaración preparada
    mysqli_stmt_close($stmt);

    // Inicializa un array para almacenar los datos de todas las tablas a las que el usuario tiene acceso
    $datos_sensores = [];

    // Realiza consultas para cada tabla a la que el usuario tiene acceso
    foreach ($tablas_acceso as $tabla) {
        // Prepara la consulta para obtener los datos de la tabla
        $stmt = mysqli_prepare($con, "SELECT * FROM " . mysqli_real_escape_string($con, $tabla));
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Almacena los datos de la tabla en el array
        $datos_sensores[$tabla] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $datos_sensores[$tabla][] = $row;
        }

        // Cierra la declaración preparada
        mysqli_stmt_close($stmt);
    }

    // Devuelve los datos de todas las tablas a las que el usuario tiene acceso como JSON
    echo json_encode($datos_sensores);
} else {
    echo json_encode(["error" => "No estás autenticado"]);
}
?>
