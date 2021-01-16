const search = document.getElementById("search-bar");
const squadContainer = document.querySelector(".squads");


search.addEventListener("keyup", function (event) {

    if (event.key === "Enter") {
        event.preventDefault();

        const data = {
            search: this.value
        };

        fetch(`/search`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(function (response) {

            return response.json();
        }).then(function (squads) {
            squadContainer.innerHTML = "";
            loadSquads(squads);

            const joinButtons = document.querySelectorAll('.join_squad')
            joinButtons.forEach(joinButton => joinButton.addEventListener("click", joinSquad));

            const deleteButtons = document.querySelectorAll('.delete_squad')
            deleteButtons.forEach(joinButton => joinButton.addEventListener("click", deleteSquad));

        });
    }
});


function loadSquads(squads) {
    squads.forEach(squad => {
        console.log(squad);
        createSquad(squad);
    });
}

function createSquad(squad) {
    const template = document.getElementById('squad-template');

    //TODO dodac poprawne dodanie buttonnu do usuwania

    const clone = template.content.cloneNode(true);

    const div=clone.getElementById('admin_buttons');

    console.log(squad.id + " "+ div);
    if(squad.role==="admin"){
        let html = "<button class=\"squad-hyper delete_squad\" >Delete squad</button>";
        div.innerHTML = html;
    }

    const image = clone.getElementById('creatorPhoto');
    image.src = `/public/img/uploads/${squad.photo}`;

    const name = clone.querySelector('h2');
    name.innerHTML = squad.name + " " + squad.surname;

    const sport = clone.querySelector('p[name="sport"]');
    sport.innerHTML = "Sport: " + squad.sport;

    const max_members = clone.querySelector('p[name="max-members"]');
    max_members.innerHTML = "Zawodników: " + squad.max_members;

    const fee = clone.querySelector('p[name="fee"]');
    fee.innerHTML = "Opłata: " + squad.fee;

    const place = clone.querySelector('p[name="place"]');
    place.innerHTML = squad.place;

    const address = clone.querySelector('p[name="address"]');
    address.innerHTML = squad.city + " " + squad.street;

    const date = clone.querySelector('p[name="date"]');
    date.innerHTML = squad.date;

    const members = clone.querySelector('.members');

    let html = "";
    for (let i = 0; i < squad.squad_count; i++) {

        let tempHtml = "<img src=\"/public/img/uploads/";
        if (i === 0) tempHtml += squad.member_0_photo + "\">";
        if (i === 1) tempHtml += squad.member_1_photo + "\">";
        if (i === 2) tempHtml += squad.member_2_photo + "\">";
        if (i === 3) tempHtml += squad.member_3_photo + "\">";
        if (i === 4) tempHtml += squad.member_4_photo + "\">";
        if (i === 5) {
            let count = squad.squad_count - 5;
            tempHtml += "numbers/" + count + ".png\">";
            html += tempHtml;
            break;
        }
        html += tempHtml;
    }
    //TODO dodac text organizator i join squad

    members.innerHTML = html;

    const joinButton=clone.getElementById("id");
    joinButton.setAttribute("id",squad.id);

    squadContainer.appendChild(clone);
}