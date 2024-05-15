function verificarSesion(){
    fetch('https://servicold.000webhostapp.com/back-end/verificar_sesion.php')
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta del servidor
            if (data.success) {
                break
            }else{
                // Usuario no autenticado, redirigir al formulario de inicio de sesión
                window.location.href = 'login.html';
            }
        })
        .catch(error => console.error('Error:', error));
}
window.onload = function() {
    verificarSesion(); // Carga los datos
};
