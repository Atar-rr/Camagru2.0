
document.getElementById('commentContainer').onclick = function (event) {
    if (event.target.className === 'close'){
        let xmlhttp = new XMLHttpRequest();

        xmlhttp.open('POST', '/comment/' + event.target.value + '/delete', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        let data = "id=" + encodeURIComponent(event.target.value);

        xmlhttp.onload = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                getComments();
            }
        }
        xmlhttp.send(data);
    }
}