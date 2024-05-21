// Define el umbral de nivel de combustible mínimo
const combustibleThreshold = 30; // Por ejemplo, 30%

// Bandera para controlar si la alerta ya se ha emitido
let alertEmitted = false;

// Función para verificar los datos del sensor de nivel de combustible
function checkCombustibleData() {
    // Realiza la solicitud HTTP GET para obtener los datos del sensor de nivel de combustible
    fetch('ruta/de/tu/api/para/obtener/datos')
        .then(response => response.json())
        .then(data => {
            // Verifica si hay datos
            if (Array.isArray(data) && data.length > 0) {
                // Muestra los resultados y verifica las lecturas bajas
                data.forEach(item => {
                    // Verifica si el nivel de combustible está por debajo del umbral
                    if (parseFloat(item.nivel_combustible) <= combustibleThreshold && !alertEmitted) {
                        // Muestra una alerta en la página
                        alert(`¡Alerta! Nivel de combustible bajo: ${item.nivel_combustible}%`);

                        // Envía un correo electrónico de alerta
                        sendEmailAlert();

                        // Establece la bandera de alerta emitida en true para evitar emitirla nuevamente
                        alertEmitted = true;
                    }
                });
            }
        })
        .catch(error => {
            // Maneja los errores
            console.error('Error al obtener los datos del sensor de nivel de combustible:', error);
        });
}

// Función para enviar un correo electrónico de alerta
function sendEmailAlert() {
    // Aquí deberías escribir el código para enviar un correo electrónico utilizando una biblioteca o servicio de correo electrónico apropiado
    // Puedes utilizar PHPMailer, nodemailer (para Node.js), o cualquier otra biblioteca compatible con el lenguaje de programación que estés utilizando en el lado del servidor
    // Si estás utilizando JavaScript en el lado del cliente, no puedes enviar correos electrónicos directamente desde el navegador debido a restricciones de seguridad
    fetch('https://servicold.000webhostapp.com/envioAlerta.php', {
        method: 'POST',
        body: JSON.stringify({
            to: 'nachoxeneize00@gmail.com',
            subject: 'Combustible bajo',
            message: 'El nivel de combustible de su tanque es menor al 30%'
        })
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Muestra la respuesta del servidor en la consola
    })
    .catch(error => {
        console.error('Error al enviar la solicitud:', error);
    });
    

}

// Llama a la función para verificar los datos del sensor de nivel de combustible cuando se carga la página
window.onload = function() {
    checkCombustibleData();
};
