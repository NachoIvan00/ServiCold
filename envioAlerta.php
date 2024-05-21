<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye las clases de PHPMailer
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Establece los encabezados CORS para permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Establece las cabeceras para evitar el almacenamiento en caché
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

// Habilita la visualización de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Función para enviar alertas por correo electrónico
function sendEmailAlert($to, $subject, $message) {
    // Crea una nueva instancia de PHPMailer
    $mail = new PHPMailer();

    try {
        // Configura el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ignacioibaigorria@gmail.com'; // Cambia esto por tu dirección de correo
        $mail->Password = 'onajqhoqiwdegphd'; // Cambia esto por tu contraseña de correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->isHTML(true); // Establece el formato del correo como HTML

        // Configura el remitente y el destinatario
        $mail->setFrom('ignacioibaigorria@gmail.com', 'Ignacio'); // Cambia esto por tu dirección de correo y tu nombre
        $mail->addAddress($to); // Agrega el destinatario

        // Configura el asunto y el cuerpo del correo
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Envía el correo electrónico
        $mail->send();
        return true; // Retorna verdadero si se envió correctamente
    } catch (Exception $e) {
        // Captura la excepción y muestra el mensaje de error
        echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
        return false; // Retorna falso si hubo un error
    }
}

// Recibe los datos del cliente desde un formulario o solicitud POST
$to = $_POST['to']; // Dirección de correo electrónico del destinatario
$subject = $_POST['subject']; // Asunto del correo electrónico
$message = $_POST['message']; // Cuerpo del correo electrónico

// Envía el correo electrónico con la función sendEmailAlert
if (sendEmailAlert($to, $subject, $message)) {
    echo 'Correo electrónico enviado con éxito';
} else {
    echo 'Error al enviar el correo electrónico';
}
?>
