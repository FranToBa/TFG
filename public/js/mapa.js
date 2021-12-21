/** Script encargado de la creación de un mapa interactivo
 * con los lugares más emblemáticos.
 */

//Creamos el mapa
let map = L.map('map').fitWorld();
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

//Creamos los iconos que usaremos para cada pokemon
var icono = new L.Icon({
    iconUrl: 'https://image.flaticon.com/icons/svg/854/854866.svg',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

var iconAyuntamiento = new L.Icon({
    iconUrl: "/images/ayun.png",
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

var iconIglesia = new L.Icon({
    iconUrl: '/images/iglesia.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

var iconBalneario = new L.Icon({
    iconUrl: '/images/balneario.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});
var iconPaseo = new L.Icon({
    iconUrl: '/images/paseo.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

var iconCampoFutbol = new L.Icon({
    iconUrl: '/images/campo_futbol.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

var iconPolideportivo = new L.Icon({
    iconUrl: '/images/polideportivo.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50]
});

/* Cuando cambie el select, obtenemos las coordenadas
 y dependiendo del lugar usamos su icono */
document.getElementById('select-location').addEventListener('change', function(e) {

    let coords = e.target.value.split(",");

    if (e.target.value == "38.04471567827674, -4.170924514961609") {
        L.marker(coords, {
            icon: iconAyuntamiento
        }).addTo(map)

    } else if (e.target.value == "38.04502032151474, -4.170849870587616") {
        L.marker(coords, {
            icon: iconIglesia
        }).addTo(map)

    } else if (e.target.value == "38.05422097155744, -4.191384862601222") {
        L.marker(coords, {
            icon: iconBalneario
        }).addTo(map)

    } else if (e.target.value == "38.042933328176574, -4.1685109842758665") {
        L.marker(coords, {
            icon: iconPaseo
        }).addTo(map)

    } else if (e.target.value == "38.0423080635287, -4.164391111199549") {
        L.marker(coords, {
            icon: iconCampoFutbol
        }).addTo(map)

    } else if (e.target.value == "38.050699997535574, -4.169629372632981") {
        L.marker(coords, {
            icon: iconPolideportivo
        }).addTo(map)
    } else {
        L.marker(coords, {
            icon: icono
        }).addTo(map)
    }
    map.flyTo(coords, 18);
});
