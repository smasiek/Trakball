const deleteButtons = document.querySelectorAll('.delete_squad')

deleteButtons.forEach(joinButton => joinButton.addEventListener("click", deleteSquad));


function deleteSquad() {

    const div=this.parentElement.parentElement
    const id = div.getAttribute("id");

    fetch(`/delete_squad/${id}`, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(function (response){
        switch (response.status) {
            case 406:
                return response.json();
            case 403:
                return response.json();
            case 200:
                return response.json();
        }
    }).then(function (message){
        alert(message.message);
        if (message.message === "You have deleted this squad") {
            history.pushState({}, 'SQUADS', window.location.pathname);
            window.location.assign(window.location.href)
        }
    });
}
