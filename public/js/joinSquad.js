const joinButtons = document.querySelectorAll('.join-squad')

joinButtons.forEach(joinButton => joinButton.addEventListener("click", joinSquad));

console.log(joinButtons);

function joinSquad() {

    const join = this;
    const id = this.getAttribute("id");

    fetch(`/join_squad/${id}`, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(function (response){
        switch (response.status) {
            case 406:
                return response.json();
            case 200:
                return response.json();
        }
    }).then(function (message){
        console.log(message);
        alert(message.message);
    });
}
