// Variables para los datos de gráficos
let fuelLevelData = [];
let labels = [];
let sensorChart;

// Variable para almacenar el número fijo de datos a mostrar
let dataLimit = 25;

// Variable para almacenar la fecha seleccionada
let selectedDate = null;

// Inicializa el gráfico de líneas con Chart.js
function initializeChart() {
    const ctx = document.getElementById('sensorChart').getContext('2d');
    sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nivel de Combustible (%)',
                data: fuelLevelData,
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    display: true,
                    title: {
                        display: true,
                        text: 'Tiempo'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Nivel de Combustible (%)'
                    },
                    // Define el rango del eje Y de 0 a 100%
                    min: 0,
                    max: 100
                }
            },
            // Hacer que el gráfico sea responsivo
            responsive: true,
            // Mantener la relación de aspecto del gráfico al cambiar el tamaño
            maintainAspectRatio: false
        }
    });
}

// Agrega la asignación del evento onchange al campo de fecha selectedDate
document.getElementById('selectedDate').addEventListener('change', filterDataByDate);

// Función para filtrar los datos por fecha
function filterDataByDate() {
    console.log("Función filterDataByDate() llamada"); // Agrega esto para verificar si la función se está ejecutando
    let selectedDateValue = new Date(document.getElementById('selectedDate').value);
    
    // Si no se selecciona ninguna fecha, establece selectedDate a null para borrar el filtro
    if (!document.getElementById('selectedDate').value) {
        selectedDate = null;
    } else {
        // Formatea la fecha como YYYY-MM-DD
        selectedDate = selectedDateValue.toISOString().split('T')[0];
    }
    
    console.log(selectedDate);
    // Llama a loadAllData con la fecha seleccionada en el formato correcto
    loadAllData(selectedDate);
}
// Define el umbral de nivel de combustible mínimo
const combustibleThreshold = 30; // Por ejemplo, 30%

// Bandera para controlar si la alerta ya se ha emitido
let alertEmitted = false;

// Función para verificar los datos del sensor de nivel de combustible
function checkCombustibleData() {
    console.log("Se está ejecutando la función checkCombustibleData()");
    // Realiza la solicitud HTTP GET para obtener los datos del sensor de nivel de combustible
    fetch('https://servicold.000webhostapp.com/checkCombustible.php',  {cache: 'no-cache' })
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
    console.log("Se llama la función sendEmailAlert()");
    
    // Construye los datos del formulario codificados
    const formData = new FormData();
    formData.append('to', 'nacho_xeneize00@hotmail.com');
    formData.append('subject', 'Combustible bajo');
    formData.append('message', 'El nivel de combustible de su tanque es menor al 30%');

    fetch('https://servicold.000webhostapp.com/envioAlerta.php', {
        method: 'POST',
        body: formData // Pasa los datos del formulario
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Muestra la respuesta del servidor en la consola
    })
    .catch(error => {
        console.error('Error al enviar la solicitud:', error);
    });
}


    


// Función para formatear la fecha en el formato deseado
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { 
        hour: 'numeric',
        minute: 'numeric',
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    };
    return date.toLocaleDateString('es-ES', options);
}

// Función para cargar los datos de la tabla y actualizar los gráficos
function loadAllData(selectedDate) {
    // URL para la solicitud a tu script PHP
    let url = `https://servicold.000webhostapp.com/FLGet.php?data_limit=${dataLimit}`;
    // Agrega el parámetro `selected_date` a la URL si se proporciona una fecha seleccionada
    if (selectedDate) {
        url += `&selected_date=${selectedDate}`;
    }
    // Realiza la solicitud HTTP GET a la URL
    fetch(url, { cache: 'no-cache' })
        .then(response => response.json())
        .then(data => {
            // Limpia el cuerpo de la tabla de resultados
            const resultBody = document.getElementById('resultBody');
            resultBody.innerHTML = '';

            // Verifica si hay datos
            if (Array.isArray(data) && data.length > 0) {
                // Limita los datos según el parámetro de dataLimit
            // Verifica si dataLimit es nulo antes de limitar los datos
            if (dataLimit) {
                data = data.slice(0, dataLimit);
            }   
                
            // Muestra los resultados en la tabla
            data.forEach(item => {
                const row = document.createElement('tr');
                // Muestra el nivel de combustible y la fecha de cada registro
                row.innerHTML = `
                    <td>${item.nivel_combustible}</td>
                    <td>${formatDate(item.fecha_actual)}</td>`;
                    resultBody.appendChild(row);

                    // Actualiza las listas de datos para los gráficos
                    labels.push(formatDate(item.fecha_actual));
                    // Convierte el nivel de combustible a un valor entre 0 y 100%
                    const fuelPercentage = (item.nivel_combustible / 100) * 100;
                    fuelLevelData.push(fuelPercentage);
                });

                // Limita las listas de datos según el dataLimit
                if (dataLimit){
                labels = (labels.slice(-dataLimit)).reverse();
                fuelLevelData = (fuelLevelData.slice(-dataLimit)).reverse();
                } else{
                    labels = labels.reverse();
                    fuelLevelData = fuelLevelData.reverse();
                }

                // Actualiza el gráfico
                sensorChart.data.labels = labels;
                sensorChart.data.datasets[0].data = fuelLevelData;
                sensorChart.update();
            } else {
                // Si no hay resultados, muestra un mensaje
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="2">No se encontraron resultados.</td>';
                resultBody.appendChild(row);
            }
        })
        .catch(error => {
            // Maneja los errores
            console.error('Error al obtener los datos:', error);
            const resultBody = document.getElementById('resultBody');
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="2">Error al obtener los datos.</td>';
            resultBody.appendChild(row);
        });
}
function verificarSesion(){
    fetch('https://servicold.000webhostapp.com/back-end/verificar_sesion.php')
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta del servidor
            if (!data.success) {
                // Usuario no autenticado, redirigir al formulario de inicio de sesión
                window.location.href = 'login.html';
            }
        })
        .catch(error => console.error('Error:', error));
}

window.onload = function() {
    verificarSesion();
    checkCombustibleData();
    initializeChart();
    loadAllData(selectedDate);  // Verifica la sesión y carga los datos
};

// Utiliza setInterval para verificar si hay nuevos datos cada 5 segundos
setInterval(() => {
    loadAllData(selectedDate);
}, 5000);

// Función para manejar el evento `change` en el menú desplegable `dataLimit`
function handleDataLimitChange() {
    // Obtén el valor de `dataLimit` desde el menú desplegable
    const dataLimitSelect = document.getElementById('dataLimit');
    const selectedDataLimit = dataLimitSelect.value;

    // Si se selecciona "Todas", establece dataLimit a null
    if (selectedDataLimit === 'all') {
        dataLimit = null;
    } else {
        // Si se selecciona un valor específico, convierte el valor a un número entero
        dataLimit = parseInt(selectedDataLimit);
    }

    // Llama a `loadAllData`
    loadAllData(selectedDate);
}

