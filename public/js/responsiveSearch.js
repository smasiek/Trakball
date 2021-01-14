const searchBar = document.getElementById("search-bar");
const newSquad = document.querySelector(".add-squad");

function showMenu() {
    // If the checkbox is checked, display the output text
    if (checkbox.checked === true){
        searchBar.style.display = "block";
        newSquad.style.display = "block";
    } else {
        searchBar.style.display = "none";
        newSquad.style.display = "none";
    }
}

checkbox.addEventListener("click",showMenu);