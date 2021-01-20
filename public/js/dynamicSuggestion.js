const form = document.querySelector("form");
const cityInput = form.querySelector('.city');
const cityData = document.getElementById('cities');
const streetInput = form.querySelector('.street');
const streetData = document.getElementById('streets');
const placeInput = form.querySelector('.name');
const placeData = document.getElementById('names');

function appendSuggestions(type,optionsData,city,street,place){
    //TODO Wrap append functions in one
}

function appendCities(city, street, place) {

    const data = {
        cityInput: city,
        streetInput: street,
        placeInput: place
    };

    fetch(`/cities`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (cities) {

        cityData.innerHTML = "";
        loadElements(cities, cityData);
    });
}

function appendStreets(city, street, place) {

    const data = {
        cityInput: city,
        streetInput: street,
        placeInput: place
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

        streetData.innerHTML = "";
        loadElements(streets, streetData);
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

        placeData.innerHTML = "";
        loadElements(places, placeData);
    });
}

function loadElements(elements, data) {
    elements.forEach(element => {
        let node = document.createElement("OPTION");
        let textNode = document.createTextNode(element);
        node.appendChild(textNode);
        data.appendChild(node);
    });
}

cityInput.addEventListener('keyup', function () {
    setNulls()
    appendCities(cityInput.value, streetInput.value, placeInput.value);
});

streetInput.addEventListener('keyup', function () {
    setNulls()
    appendStreets(cityInput.value, streetInput.value, placeInput.value);

});

placeInput.addEventListener('keyup', function () {
    setNulls()
    appendPlaces(cityInput.value, streetInput.value, placeInput.value);
});

function setNulls() {
    if (cityInput.value == null)
        cityInput.value = '';
    if (placeInput.value == null)
        placeInput.value = '';
    if (streetInput.value == null)
        streetInput.value = '';
}

