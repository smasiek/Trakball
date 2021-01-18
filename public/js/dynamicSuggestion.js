const form = document.querySelector("form");
const cityInput = form.querySelector('.city');
const cityData = document.getElementById('cities');
const streetInput = form.querySelector('.street');
const streetData = document.getElementById('streets');
const placeInput = form.querySelector('.name');
const placeData = document.getElementById('names');
const sportInput = form.querySelector('.sport');
const sportData = document.getElementById('sports');
const maxPlayersInput = form.querySelector('.max_players');
const feeInput = form.querySelector('.fee');
const publishButton = document.getElementById('publish');

function appendCities(city) {

    const data = {cityInput: city};

    fetch(`/cities`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (cities) {

        let count = cityData.childElementCount;
        for (let i = 0; i < count; i++) {
            cityData.removeChild(cityData.childNodes[i]);
        }
        loadCities(cities);
    });
}

function appendStreets(city, street) {

    const data = {
        cityInput: city,
        streetInput: street
    };

    fetch(`/streets`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (streets) {

        let count = streetData.childElementCount;
        for (let i = 0; i < count; i++) {
            streetData.removeChild(streetData.childNodes[i]);
        }
        loadStreets(streets);
    });
}

function appendPlaces(city, street, place) {

    const data = {
        cityInput: city,
        streetInput: street,
        placeInput: place
    };

    fetch(`/places`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (places) {

        let count = placeData.childElementCount;
        for (let i = 0; i < count; i++) {
            placeData.removeChild(placeData.childNodes[i]);
        }
        loadPlaces(places);
    });
}

function loadCities(cities) {
    //cities to powinna byc tablica cities["Kraków","Warszawa",...];
    cities.forEach(city => {
        let node = document.createElement("OPTION");
        let textNode = document.createTextNode(city);
        node.appendChild(textNode);
        cityData.appendChild(node);
    });
}

function loadStreets(streets) {
    streets.forEach(street => {
        let node = document.createElement("OPTION");
        let textNode = document.createTextNode(street);
        node.appendChild(textNode);
        streetData.appendChild(node);
    });
}

function loadPlaces(places) {
    places.forEach(place => {
        let node = document.createElement("OPTION");
        let textNode = document.createTextNode(place);
        node.appendChild(textNode);
        placeData.appendChild(node);
    });
}


cityInput.addEventListener('keyup', function () {
    /*    setTimeout(
      ()=>appendCities(cityInput.value)
      , 500);*/
    if (cityInput.value != null)
        appendCities(cityInput.value);

});

streetInput.addEventListener('keyup', function () {
    if (cityInput.value != null && streetInput.value != null)
        appendStreets(cityInput.value, streetInput.value);
});

placeInput.addEventListener('keyup', function () {
    if (cityInput.value != null && streetInput.value != null && placeInput.value != null)
        appendPlaces(cityInput.value, streetInput.value, placeInput.value);
});

