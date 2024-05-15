<?php

include 'conexion.php';

if ($con) {
    echo "Conexión con base de datos exitosa! ";
    
    // Verifica si se enviaron los datos de nivel de combustible
    if (isset($_POST['nivel_combustible'])) {
        $nivel_combustible = $_POST['nivel_combustible'];
        echo " Nivel de combustible enviado: " . $nivel_combustible;
        
        // Establece la zona horaria (ajusta según tu ubicación)
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha_actual = date("Y-m-d H:i:s");
        
        // Prepara la consulta SQL para insertar los datos en la tabla FL-902
        $consulta = "INSERT INTO `FL902` (nivel_combustible, fecha_actual, usuario_id) VALUES ('$nivel_combustible', '$fecha_actual', 1)";
        
        // Ejecuta la consulta
        $resultado = mysqli_query($con, $consulta);
        
        if ($resultado) {
            echo " Registro en base de datos OK! ";
        } else {
            echo " Falla! Registro BD";
        }
    } else {
        echo "No se enviaron datos de nivel de combustible";
    }
} else {
    echo "Falla! Conexión con base de datos ";
}

?>
