<?php
include 'conexion.php';

if ($con) {
    $sql = "SELECT id, nombre FROM sensores";
    $result = mysqli_query($con, $sql);
    $sensores = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $sensores[] = $row;
    }

    echo json_encode($sensores);
    mysqli_close($con);
} else {
    echo json_encode([]);
}
?>
