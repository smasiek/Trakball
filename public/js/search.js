const search=document.getElementById("search-bar");
const squadContainer=document.querySelector(".squads");


search.addEventListener("keyup", function (event) {
    /*if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (squads) {
            squadContainer.innerHTML = "";
            loadSquads(squads)
        });
    }*/

    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value
        };

        fetch(`/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(function(response){

            return response.json();
        }).then(function (squads) {
            squadContainer.innerHTML = "";
            loadSquads(squads)
        });

            /*}).then(function (response) {
            return response.json();
        }).then(function (squads) {
            squadContainer.innerHTML = "";
            loadSquads(squads)
        });*/
    }
});


function loadSquads(squads) {
    squads.basic.forEach(squad => {
        console.log(squad);
        createSquad(squad);
    });
}

function createSquad(squad){
    const template = document.getElementById('squad-template');

    const clone = template.content.cloneNode(true);

    //TODO querySelectorem powybierac wszystkie elementy kafelka i podstawić odpowiednio
    const image = clone.getElementById('creatorPhoto');
    image.src=`/public/img/uploads/${squad.photo}`;

    const name=clone.querySelector('h2');
    name.innerHTML=squad.name+" "+squad.surname;

    const sport=clone.querySelector('p[name="sport"]');
    sport.innerHTML=squad.sport;
//TODO moze byc konieczne dodanie user_details.name/surname
    const max_members=clone.querySelector('p[name="max-members"]');
    max_members.innerHTML=squad.max_members;

    const fee=clone.querySelector('p[name="fee"]');
    fee.innerHTML=squad.fee;

    const place=clone.querySelector('p[name="place"]');
    place.innerHTML=squad.place;

    const address=clone.querySelector('p[name="address"]');
    address.innerHTML=squad.city + " " + squad.street;

    const date=clone.querySelector('p[name="date"]');
    date.innerHTML=squad.date;

    squadContainer.appendChild(clone);

}