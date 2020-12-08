var passwordControl =  document.getElementById('password-control');
var confirmControl =  document.getElementById('confirm-control');

if (passwordControl !== null) {
    passwordControl.onclick = function () {
        showPassword(this);
    };
}

if (confirmControl !== null) {
    confirmControl.onclick = function () {
        showPassword(this);
    };
}

function showPassword(action)
{
    if (action.id === 'password-control') {
        let password = document.getElementById('password');
        let passwordControl = document.getElementById('password-control');

        if (password.getAttribute('type') === 'password') {
            passwordControl.classList.add('view');
            password.setAttribute('type', 'text');
        } else {
            passwordControl.classList.remove('view');
            password.setAttribute('type', 'password');
        }
    } else if (action.id === 'confirm-control') {
        let confirm = document.getElementById('confirm');
        let confirmControl =  document.getElementById('confirm-control');

        if (confirm.getAttribute('type') === 'password') {
            confirmControl.classList.add('view');
            confirm.setAttribute('type', 'text');
        } else {
            confirmControl.classList.remove('view');
            confirm.setAttribute('type', 'password');
        }
    }
}