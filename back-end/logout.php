<?php

session_start();
session_destroy();  // Destruye la sesión para cerrar sesión
header("Location: https://servicold.000webhostapp.com/login.html");  // Redirige a la página de inicio de sesión

?>