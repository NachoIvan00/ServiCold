document.addEventListener('DOMContentLoaded', function() {
    // Realizar la solicitud GET al archivo PHP para obtener los sensores del usuario
    fetch('https://servicold.000webhostapp.com/back-end/sensoresUsuario.php')
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta del servidor
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }

            // Obtener el contenedor de la lista de sensores
            const sensorList = document.getElementById('sensorList');

            // Iterar sobre la lista de sensores y mostrarlos como enlaces
            data.forEach(sensor => {
                const sensorLink = document.createElement('a');
                sensorLink.textContent = sensor.nombre;
                sensorLink.href = `https://servicold.000webhostapp.com/${sensor.nombre}.html`; // Enlace a la página del sensor
                sensorLink.classList.add('sensor-link'); // Agregar una clase para estilos opcionales
                sensorList.appendChild(sensorLink);
                sensorList.appendChild(document.createElement('br')); // Agregar un salto de línea
            });
        })
        .catch(error => console.error('Error:', error));
});
