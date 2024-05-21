const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que se envíe el formulario por defecto

    // Obtener los valores de correo electrónico y contraseña del formulario
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Objeto con los datos del formulario
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    // Realizar la solicitud POST al archivo PHP para el inicio de sesión
    fetch('https://servicold.000webhostapp.com/back-end/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta del servidor
        if (data.mensaje) {
            // Inicio de sesión exitoso, redirigir al usuario a otra página
            window.location.href = 'https://servicold.000webhostapp.com/index.html';
        } else {
            // Inicio de sesión fallido, mostrar mensaje de error
            alert(data.error || 'Inicio de sesión fallido. Por favor, verifica tus credenciales.');
        }
    })
    .catch(error => {
        // Manejar errores de la solicitud
        console.error('Error al iniciar sesión:', error);
        alert('Error al iniciar sesión. Por favor, inténtalo de nuevo más tarde.');
    });
});
