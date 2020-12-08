var login = document.getElementById('login');
var password = document.getElementById('password');
var loginSubmit = document.getElementById('loginSubmit');

let loginValidator = function (input) {
    let loginError = document.getElementById('loginError');
    let passwordError = document.getElementById('passwordError');

    if (input.id === 'login' || input.id === 'loginSubmit') {
        if (login.value === '' && loginError === null) {
            let loginContainer = document.getElementById('loginContainer');
            let div = document.createElement('div');

            div.innerText = 'Обязательное поле';
            div.id = "loginError";
            div.className = 'invalid-feedback';

            login.className += ' is-invalid';
            loginContainer.appendChild(div);
        } else if (input.value !== '' && loginError !== null) {
            loginError.remove();
            login.classList.replace('is-invalid', 'is-valid');
        }
    }
    if (input.id === 'password' || input.id === 'loginSubmit') {
        if (password.value === '' && passwordError === null) {
            let passwordContainer = document.getElementById('passwordContainer');
            let div = document.createElement('div');

            div.innerText = 'Обязательное поле';
            div.id = "passwordError";
            div.className += 'invalid-feedback error-absolute';

            password.className += ' is-invalid';
            passwordContainer.appendChild(div);

        } else if (input.value !== '' && passwordError !== null) {
            passwordError.remove();
            password.classList.replace('is-invalid', 'is-valid');
        }
    }

}

login.addEventListener('focusout', function () {
    loginValidator(this);
});

password.addEventListener('focusout', function () {
    loginValidator(this);
});

loginSubmit.onclick = function (event) {
    loginValidator(this);
    if (document.getElementById('passwordError') !== null || document.getElementById('loginError') !== null) {
        if (event !== null) {
            event.preventDefault();
        }
    }
}