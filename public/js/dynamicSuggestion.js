const form = document.querySelector("form");
const cityInput = form.querySelector('input[name="city"]');
const cityData=document.getElementById('cities');
const streetInput = form.querySelector('input[name="street"]');
const streetData=document.getElementById('streets');
const nameInput = form.querySelector('input[name="name"]');
const nameData=document.getElementById('names');
const sportInput = form.querySelector('input[name="sport"]');
const sportData=document.getElementById('sports');
const maxPlayersInput = form.querySelector('input[name="max_players"]');
const feeInput = form.querySelector('input[name="fee"]');
const publishButton = document.getElementById('publish');

function appendCities(city) {

    const data = {cityInput: this.value};

    fetch(`/cities`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    }).then(function(response){
        return response.json();
    }).then(function (cities) {

        let count = cityData.childElementCount;
        for (let i=0;i<count;i++){
            cityData.removeChild(cityData.childNodes[i]);
        }
        loadCities(cities);
    });
}

function loadCities(cities){
    //cities to powinna byc tablica cities["Kraków","Warszawa",...];
    cities.forEach(city => {
        let node=document.createElement("OPTION");
        let textNode=document.createTextNode(city);
        node.appendChild(textNode);
        cityData.appendChild(node);
    });
}


cityInput.addEventListener('keyup', function () {
  //  setTimeout(function () {
            //appendElements(cityInput, getCities(cityInput.value));
        //}, 500);

    appendCities(cityInput.value);
});
