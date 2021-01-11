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

        const data = {search: this.value};

        fetch(`/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        }).then(function(response){
            const body =  response.json();
            console.log(body);
        })

            /*}).then(function (response) {
            return response.json();
        }).then(function (squads) {
            squadContainer.innerHTML = "";
            loadSquads(squads)
        });*/
    }
});


function loadSquads(squads) {
    squads.forEach(squad => {
        console.log(squad);
        createSquad(squad);
    });
}

function createSquad(squad){
    const template = document.querySelector("#squad-template");

    const clone = template.content.cloneNode(true);

    //TODO querySelectorem powybierac wszystkie elementy kafelka i podstawić odpowiednio
    const image = clone.querySelector('img[id="creatorPhoto"]');
    image.src=`/public/uploads/${squad.photo}`;
/*
    const sport=clone.querySelector('p[name="sport"]');
    sport.innerHTML=squad.user_details.name+" "+squad.user_details.surname;
//TODO moze byc konieczne dodanie user_details.name/surname
    const max_members=clone.querySelector('p[name="max-members"]');
    max_members.innerHTML=squad.max_members;

    const fee=clone.querySelector('p[name="fee"]');
    fee.innerHTML=squad.fee;

    const place=clone.querySelector('p[name="place"]');
    place.innerHTML=squad.places.name;*/

    squadContainer.appendChild(clone);

}