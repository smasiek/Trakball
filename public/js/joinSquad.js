const joinButtons = document.querySelectorAll('.join_squad')

joinButtons.forEach(joinButton => joinButton.addEventListener("click", joinSquad));


function joinSquad() {

    const join = this;
    const id = this.getAttribute("id");

    fetch(`/join_squad/${id}`, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(function (response) {
        switch (response.status) {
            case 406:
                return response.json();
            case 200:
                return response.json();
        }
    }).then(function (message) {
        alert(message.message);
            if(message.message!=="You have joined this squad earlier!") {
                history.pushState({}, 'SQUADS', window.location.pathname);
                window.location.assign(window.location.href)
            }
    });
}
