const textButtons = document.querySelectorAll('.text_organizer')

textButtons.forEach(textButton => textButton.addEventListener("click", textOrganizer));


function textOrganizer(){
    const text=this;
    const container=text.parentElement.parentElement.parentElement;
    const id= container.getAttribute("id");

    fetch(`/text_organizer/${id}`,{
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(function (response) {
        return response.json();
    }).then(function (message) {
        alert(message.message);
    });

}
