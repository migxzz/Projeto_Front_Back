document.addEventListener('DOMContentLoaded', () => {
    const locationElement = document.getElementById('location');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                locationElement.textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
            },
            error => {
                locationElement.textContent = 'Não foi possível obter a localização.';
                console.error('Erro ao obter localização:', error);
            }
        );
    } else {
        locationElement.textContent = 'Geolocalização não é suportada pelo seu navegador.';
    }
});
