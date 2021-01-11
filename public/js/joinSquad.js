const joinButton=document.querySelectorAll('#join_squad')

function joinSquad(){
    const join=this;
    const container=join.parentElement.parentElement.parentElement;
    const id= container.getAttribute("id");

    fetch(`/join_squad/${id}`,{
        method: 'GET', headers: {'Content-Type': 'application/json'},
    }).then((response) => response.json().then(res => ({status: response.status, data: res})))
        .then((apiResponse) => {
            alert("TEST");
            console.log(apiResponse)
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    
}

joinButton.forEach(button=>button.addEventListener("click",joinSquad))