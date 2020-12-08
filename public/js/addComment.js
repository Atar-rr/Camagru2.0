let addComment = document.getElementById('addComment');

let sendComment = function () {
    let inputComment = document.getElementById('inputComment');
    let user_id = document.getElementById('user_id').value;
    let photo_id = document.getElementById('photo_id').value;

    if (inputComment.value !== '') {
        let xmlhttp = new XMLHttpRequest();

        xmlhttp.open('POST', '/comment', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let data = "user_id=" + encodeURIComponent(user_id)
            + "&photo_id=" + encodeURIComponent(photo_id)
            + "&text=" + encodeURIComponent(inputComment.value)
        ;

        xmlhttp.onload = function () {
            if (xmlhttp.status === 200) {
                 getComments();
            }
        }
        xmlhttp.send(data);
        inputComment.value = '';
    }

}

addComment.addEventListener('click', sendComment);