const mymap = L.map('map').setView([50.06143, 19.93658], 13);

const attribution =
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const tiles=L.tileLayer(tileUrl,{attribution})

tiles.addTo(mymap)

const marker = L.marker([0.0,0.0]).addTo(mymap);
marker.setLatLng([50.06143, 19.93658]);


//TODO: zapytanie w MapRepository które da mi info o places, potem fetch info, w petli markery, do markerów listenery,
// listener przekierowuje na widok miejsca squads z załączonym filtrem LUB widok miejsca
//TODO: widok miejsca z możliwościa wejscia do squads z filtrem lub przekierowanie na mape z zoomem w to miejsce
//TODO: routing z parametrem dotyczącym zoom'a i do squads routing z filtrem w url