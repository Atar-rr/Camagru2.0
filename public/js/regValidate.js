const regExpEmail = new RegExp(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i);
var login = document.getElementById('login');
var password = document.getElementById('password');
var confirm = document.getElementById('confirm');
var email = document.getElementById('email');
var submit = document.getElementById('submit');


let regValidator = function (input) {
    let loginError = document.getElementById('loginError');
    let passwordError = document.getElementById('passwordError');
    let confirmError = document.getElementById('confirmError');
    let emailError = document.getElementById('emailError');
    let error = false;

    if (input.id === 'login' || input.id === 'submit') {
        let loginContainer = document.getElementById('loginContainer');
        let div = document.createElement('div');

        if (loginError !== null) {
            loginError.remove();
            login.classList.replace('is-invalid', 'is-valid');
        }

        if (login !== null) {
            if (login.value === '') {
                div.innerText = 'Обязательное поле';
                error = true;

            } else if (login.value.length < 3 || login.value.length > 255) {
                div.innerText = 'Логин должен быть от 3 до 20 символов';
                error = true;
            }
        }

        /* Проверяем нужно ли создавать ошибку */
        if (error) {
            div.id = "loginError";
            div.className = 'invalid-feedback';

            login.className += ' is-invalid';

            loginContainer.appendChild(div);
        }
        error = false;
    }
    if (input.id === 'email' || input.id === 'submit') {
        let emailContainer = document.getElementById('emailContainer');
        let div = document.createElement('div');

        if (emailError !== null) {
            emailError.remove();
            email.classList.replace('is-invalid', 'is-valid');
        }

        if (email !== null) {
            if (email.value === '') {
                div.innerText = 'Обязательное поле';
                error = true;

            } else if (!regExpEmail.test(email.value)) {
                div.innerText = 'Укажите правильный email';
                error = true;
            }
        }

        /* Проверяем нужно ли создавать ошибку */
        if (error) {
            div.id = "emailError";
            div.className = 'invalid-feedback';

            email.className += ' is-invalid';

            emailContainer.appendChild(div);
        }
        error = false;
    }
    if (input.id === 'password' || input.id === 'submit') {
        let passwordContainer = document.getElementById('passwordContainer');
        let div = document.createElement('div');

        if (passwordError !== null) {
            passwordError.remove();
            password.classList.replace('is-invalid', 'is-valid');
        }

        if (password !== null) {
            if (password.value === '') {
                div.innerText = 'Обязательное поле';
                error = true;

            } else if (password.value.length < 8 || password.value.length > 255) {
                div.innerText = 'Пароль должен быть от 8 до 255 символов';
                error = true;
            }
        }


        /* Проверяем нужно ли создавать ошибку */
        if (error) {
            div.id = "passwordError";
            div.className += 'invalid-feedback error-absolute';

            password.className += ' is-invalid';
            passwordContainer.appendChild(div);
        }
        error = false;
    }
    if (input.id === 'confirm' || input.id === 'submit') {
        let confirmContainer = document.getElementById('confirmContainer');
        let div = document.createElement('div');

        if (confirmError !== null) {
            confirmError.remove();
            confirm.classList.replace('is-invalid', 'is-valid');
        }

        if (confirm !== null) {
            if (confirm.value === '') {
                div.innerText = 'Обязательное поле';
                error = true;
            } else if (confirm.value !== password.value) {
                div.innerText = 'Пароли не совпадают';
                error = true;
            } else if (confirm.value.length < 8 || confirm.value.length > 255) {
                div.innerText = 'Пароль должен быть от 8 до 255 символов';
                error = true;
            }
        }


        /* Проверяем нужно ли создавать ошибку */
        if (error) {
            div.id = "confirmError";
            div.className += 'invalid-feedback error-absolute';

            confirm.className += ' is-invalid';

            confirmContainer.appendChild(div);
        }
        error = false;
    }
}

if (login !== null ) {
    login.addEventListener('focusout', function () {
        regValidator(this);
    });
}

if (password !== null) {
    password.addEventListener('focusout', function () {
        regValidator(this);
    });
}

if (confirm !== null) {
    confirm.addEventListener('focusout', function () {
        regValidator(this);
    });
}

if (email !== null) {
    email.addEventListener('focusout', function () {
        regValidator(this);
    });
}

submit.onclick = function (event) {
    regValidator(this);
    if (document.getElementById('passwordError') !== null
        || document.getElementById('loginError') !== null
        || document.getElementById('confirmError') !== null
        || document.getElementById('emailError') !== null
    ) {
        if (event !== null) {
            event.preventDefault();
        }
    }
}