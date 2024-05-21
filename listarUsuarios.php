<?php
include 'conexion.php';

if ($con) {
    $sql = "SELECT id, nombre, email FROM usuarios";
    $result = mysqli_query($con, $sql);
    $usuarios = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    mysqli_close($con);
} else {
    echo json_encode([]);
}
?>
