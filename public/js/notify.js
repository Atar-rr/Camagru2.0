let checkbox = document.getElementById('checkbox');

checkbox.onchange = function () {
    console.log(this);

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.open('POST', '/setting/notify', true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    let data = "notify=" + this.value;

    xmlhttp.onload = function () {
        if (xmlhttp.status === 200) {
        }
    }
    xmlhttp.send(data);
    checkbox.value = this.value === "1" ? "0" : "1";
}