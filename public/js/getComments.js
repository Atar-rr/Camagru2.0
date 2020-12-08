
function getComments()
{
    let xmlhttp = new XMLHttpRequest();
    let photo_id = document.getElementById('photo_id').value;
    xmlhttp.open('GET', '/comment?' + 'photo_id=' + photo_id, true);
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

            let commentContainer = document.getElementById("commentContainer");
            while (commentContainer.firstChild) {
                commentContainer.removeChild(commentContainer.firstChild);
            }
            for(let i = 0; i < data['comments'].length; i++) {
                let small = document.createElement('small');
                let small2 = document.createElement('p');
                let strong = document.createElement('strong');
                let br = document.createElement('br');
                let button = document.createElement('button');

                if (data['comments'][i]['is_user_comment'] === true) {
                    button.className = "close";
                    button.type = "button";
                    button.innerText = "x";
                    button.value = data['comments'][i]['id'];
                    button.style = "font-size: 15px";
                }

                strong.innerText = data['comments'][i]['login']
                small.className = 'text-muted';
                small2.className = 'card-text';
                small2.innerText = data['comments'][i]['text'];

                small.appendChild(strong);
                if (data['comments'][i]['is_user_comment'] === true) {
                    commentContainer.appendChild(button);
                }
                small.innerText += ' ' + data['comments'][i]['created_at'];

                commentContainer.appendChild(small);
                commentContainer.appendChild(br);
                commentContainer.appendChild(small2);
            }
        }
    };
}


window.addEventListener('load', getComments);