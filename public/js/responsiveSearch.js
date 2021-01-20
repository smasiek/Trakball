const searchBar = document.getElementById("search-bar");
const newSquad = document.querySelector(".add-squad");

function showMenu() {
    // If the checkbox is checked, display searchbar
    if (checkbox.checked === true){
        searchDisplay("block");
    } else {
        searchDisplay("none");
    }
}

checkbox.addEventListener("click",showMenu);

function searchDisplay(value){
    searchBar.style.display = value;
    newSquad.style.display = value;
}