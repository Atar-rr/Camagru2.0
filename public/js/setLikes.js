let likeButton = document.getElementById('likeButton');

let changeLike = function (event) {
    event.preventDefault();
    let user_id = document.getElementById('user_id').value;
    let photo_id = document.getElementById('photo_id').value;
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', '/like', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    let data = "user_id=" + encodeURIComponent(user_id) +
        "&photo_id=" + encodeURIComponent(photo_id);
    xmlhttp.onload = function () {
        if (xmlhttp.status === 200) {
            getLikes();
        }
    }
    xmlhttp.send(data);
}

likeButton.addEventListener('click', changeLike);