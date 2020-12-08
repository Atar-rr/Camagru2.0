
function getLikes()
{
    let xmlhttp = new XMLHttpRequest();
    let photo_id = document.getElementById('photo_id').value;
    xmlhttp.open('GET', '/like?' + 'photo_id=' + photo_id, true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
    xmlhttp.onload = function() {
            if (xmlhttp.status === 200) {
                let data = xmlhttp.responseText;

                try {
                    data = JSON.parse(data);
                } catch (e) {
                    return false;
                }

                let element = document.getElementById("likesCount");
                element.innerText = data['total'];
                element = document.getElementById("like");
                if (data['user_is_like'] === true) {
                    element.style.color = 'red';
                } else {
                    element.style.color = 'black';
                }
            }
    };
}

window.addEventListener('load', getLikes);