const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmedPasswordInput = form.querySelector('input[name="confirmedPassword"]');
const phoneInput = form.querySelector('input[name="phone"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isPhone(phone) {
    return /^\+?\d+$/.test(phone);
}

function arePasswordsSame(password, confirmedPassword) {
    return password == confirmedPassword;
}

function markValidation(element, condition) {

    if(condition){
        element.classList.remove('no-valid');
    } else {
        element.classList.add('no-valid');
    }
}

emailInput.addEventListener('keyup', function () {
    setTimeout(function () {
            markValidation(emailInput, isEmail(emailInput.value));
        },
        1000
    );
});

confirmedPasswordInput.addEventListener('keyup', function () {
    setTimeout(function () {
        const condition = arePasswordsSame(
            confirmedPasswordInput.previousElementSibling.value,
            confirmedPasswordInput.value);
            markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
});

phoneInput.addEventListener('keyup', function () {
    setTimeout(function () {
            markValidation(phoneInput, isPhone(phoneInput.value));
        },
        1000
    );
});
