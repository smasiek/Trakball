const checkbox=document.getElementById('show-menu');
const menu = document.getElementById("menu");

function showMenu() {
    // If the checkbox is checked, display the output text
    if (checkbox.checked == true){
        menu.style.display = "block";
    } else {
        menu.style.display = "none";
    }
}

checkbox.addEventListener("click",showMenu)