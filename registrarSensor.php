<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    // Verifica la conexión a la base de datos
    if ($con) {
        $sql = "INSERT INTO sensores (nombre) VALUES ('$nombre')";
        if (mysqli_query($con, $sql)) {
            echo "<script>
            alert('Sensor registrado con éxito.');
            window.location.href = 'aDmINnnisTrADor.html'; //
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        // Crear el contenido HTML de la página del sensor
        $html = '
        <!DOCTYPE html>
        <html lang="es">
        
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $nombre . '</title>
            <link rel="icon" href="https://servicold.000webhostapp.com/src/favicon.png" type="image/x-icon">
            <!-- Enlace a Bootstrap 5 -->
            <link rel="stylesheet" href="https://servicold.000webhostapp.com/node_modules/bootstrap/dist/css/bootstrap.min.css">
            <!-- Enlace a tu archivo de estilos CSS -->
            <link rel="stylesheet" type="text/css" href="https://servicold.000webhostapp.com/css/styles.css">
            <!-- Enlace a Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <!-- Enlace a JavaScript de Bootstrap 5 -->
            <script src="https://servicold.000webhostapp.com/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        </head>
        
        <body>
            <header>
                <div class="container-fluid text-center">
                    <nav class="navbar navbar-expand-md navbar-light justify-content-center">
                    <div class="navbar-brand">
                        <a href="index.html">
                            <img src="https://servicold.000webhostapp.com/src/logo-servicold.png" alt="Logo de ServiCold" class="logo" style="height: 60px;">
                        </a>
                    </div>
                    </nav>
                    <nav class="navbar navbar-expand-md navbar-light justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/back-end/logout.php" class="nav-link" style="font-size: 14px;">Cerrar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a href="cambiarPassword.html" class="nav-link" style="font-size: 14px;">Cambiar contraseña</a>
                            </li>
                            <li class="nav-item">
                                <a href="Manual de usuario.pdf" class="nav-link" style="font-size: 14px;">Ayuda</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </header>
        
            <!-- Sección principal -->
            <div class="container principal">
                <h1>' . $nombre . '</h1>
                <!-- El resto de tu contenido aquí -->
            </div>
        
            <!-- Enlace al archivo de scripts JavaScript específico del sensor -->
            <script src="https://servicold.000webhostapp.com/' . strtolower(str_replace(' ', '', $nombre)) . '.js"></script>
        </body>
        
        </html>
        ';
        
        // Guardar el contenido HTML en un nuevo archivo
        $nombreArchivo = strtolower(str_replace(' ', '', $nombre)) . '.html'; // Nombre de archivo basado en el nombre del sensor
        $rutaArchivo = 'https://servicold.000webhostapp.com/' . $nombreArchivo; // Ruta donde deseas guardar el archivo
        file_put_contents($rutaArchivo, $html);
        
        // Redireccionar a la página del nuevo sensor
        header('Location: ' . $nombreArchivo);
    exit;
        mysqli_close($con);
    } else {
        echo "Error de conexión a la base de datos.";
    }
}
?>
