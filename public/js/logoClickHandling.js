const logo=document.querySelector('.logo')
const logoSmall=document.querySelector('.logo_small')

if(logo!=null) logo.addEventListener("click", homePage);
if(logoSmall!=null) logoSmall.addEventListener("click", homePage);

function homePage(){
    history.pushState({}, 'SQUADS', 'squads');
    window.location.assign(window.location.href)
}