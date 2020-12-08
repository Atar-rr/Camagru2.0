
let alertClose = document.getElementById('alertX');

if (alertClose !== null) {
    alertClose.onclick = function () {
        this.parentNode.remove();
    }
}