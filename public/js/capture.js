const width = 500;
const height = 400;
let dX = 80;
let dY = 80;
let mask;
let turnCamera = document.getElementById('turnCamera');
let uploadPhoto = document.getElementById('uploadPhoto');
let savePhoto = document.getElementById('savePhoto');

document.onload = getUserGallery();

uploadPhoto.onchange = function () {
    if (this.files && this.files[0]) {
        let reader = new FileReader();
        if (this.files[0].type !== 'image/png'
            && this.files[0].type !== 'image/jpg'
            && this.files[0].type !== 'image/jpeg'
        ) {
            alert('К загрузке доступны только png и jpg файлы');
            this.value = '';
            return ;
        }


        hiddenBlackBox();
        hiddenTurnCamera();
        hiddenUploadPhoto();
        showSavePhoto();
        createCanvas();
        showMasks();

        reader.onload = function (event) {
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let img = new Image();
            canvas.width = width;
            canvas.height = height;

            img.onload = function() {
                context.drawImage(img, 0, 0, width, height);
            };
            img.src = event.target.result;
        }
        reader.readAsDataURL(this.files[0]);
        this.value = '';
    }
};

turnCamera.addEventListener('click', function () {
    var video = document.getElementById('video');
    var makePhoto = document.getElementById('makePhoto');

    navigator.mediaDevices.getUserMedia({video: {width: width, height: height}, audio: false})
        .then(function (stream) {
            showVideo();
            showMasks();

            video.srcObject = stream;
            video.play();
        }).catch(function (err) {
        console.log("An error occurred: " + err);
    });
    if (makePhoto !== null) {
        makePhoto.addEventListener('click', function (ev) {
            hiddenVideo();
            createCanvas();
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            video.pause();
            hiddenMakePhoto();
            showSavePhoto();
        });
    }

}, false);


savePhoto.onclick = function ()
{
    const request = new XMLHttpRequest();
    const url = "/photo/new";
    let canvas = document.getElementById('canvas');
    let title  = document.getElementById('title');
    let photo;
    let masks = '';

    let imageContainer = document.getElementById('imageContainer');
    let canvasMasks = document.createElement('canvas');

    canvasMasks.width = imageContainer.offsetWidth;
    canvasMasks.height = imageContainer.offsetHeight;
    let contextMasks = canvasMasks.getContext('2d');
    let maskContainer = document.getElementById('maskContainer');

    for (let i = 0; i < maskContainer.children.length; i++) {
        const currentCanvas = maskContainer.children[i];
        currentCanvas.getContext('2d');
        contextMasks.drawImage(currentCanvas, 0, 0);
    }

    photo = canvas.toDataURL('image/png');

    if (maskContainer.children.length !== 0) {
       masks = canvasMasks.toDataURL('image/png');
    }

    while (maskContainer.firstChild) {
        maskContainer.removeChild(maskContainer.firstChild);
    }

    clearCheckbox();
    hiddenMasks();

    let params = 'photo=' + encodeURIComponent(photo) + '&' + 'title=' + title.value + '&' + 'masks=' + encodeURIComponent(masks);
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", function () {
        if (request.readyState === 4 && request.status === 200) {
            // console.log(request.responseText);
            getUserGallery();
            clearAll();
        }
    });
    request.send(params);
}

function createMask(data)
{
    mask = document.getElementById(data);
    let maskId = "mask_canvas_" + mask.id;

    let elem = document.getElementById(maskId);

    if (elem !== null) {
        elem.remove();
    } else {
        addMasks();
    }
}

function addMasks() {
    let maskId = "mask_canvas_" + mask.id;
    let canvas = document.createElement('canvas');
    let maskContainer = document.getElementById('maskContainer');
    let imageContainer = document.getElementById('imageContainer');

    let elem = document.getElementById(maskId);
    if (elem !== null) {
        elem.remove();
    }

    canvas.width = imageContainer.offsetWidth;
    canvas.height = imageContainer.offsetHeight;
    canvas.draggable = true;
    canvas.id = maskId;
    canvas.style.zIndex = '1';
    canvas.style.position = 'absolute'
    canvas.addEventListener("click", getClickPosition, false);

    maskContainer.appendChild(canvas);

    let img = new Image();
    img.src = mask.value;

    let context = canvas.getContext('2d');
    context.drawImage(img, dX, dY, imageContainer.offsetWidth / 5, imageContainer.offsetHeight / 5);
    // zIndex++;
}

function getClickPosition(e) {
    if (mask) {
        let rect = document.getElementById('video').getBoundingClientRect();
        dX = e.clientX - rect.left - (80 / 2);
        dY = e.clientY - rect.top - (80 / 2);
        addMasks();
    }
}


function getUserGallery()
{
    const request = new XMLHttpRequest();
    const url = "/photo/user-gallery";

    request.open("GET", url);

    request.onload = function () {
        if (request.status === 200) {
            let data = request.responseText;
            try {
                JSON.parse(data);
                makeGallery(JSON.parse(data))
            } catch (e) {
                return false;
            }
        }
    }

    request.send();
}

function makeGallery(data)
{
    let galleryContainer = document.getElementById('galleryContainer');
    let len = data.length;

    while (galleryContainer.firstChild) {
        galleryContainer.removeChild(galleryContainer.firstChild);
    }
    if (len === 0) {
        return ;
    }

    for (let i = 0; i < len; i++)
    {
        let div = document.createElement('div');
        let a = document.createElement('a');
        let img = document.createElement('img');

        div.className = "col-md-2 col-sm-2 col-lg-2 thumb";
        a.target = "_self";
        img.className = "img-fluid";
        a.href = "/photo/" + data[i]['id'];
        img.src = data[i]['photo'];
        galleryContainer.appendChild(div);
        div.appendChild(a);
        a.appendChild(img);
    }
}

function createCanvas() {
    let imageContainer = document.getElementById('imageContainer');
    let elem = document.getElementById('canvas');
    if (elem === null) {
        let canvas = document.createElement('canvas');

        canvas.id = "canvas";
        canvas.className = "card-img-top embed-responsive-item";

        imageContainer.appendChild(canvas);
    }
}

function clearCheckbox()
{
   let data = document.getElementsByClassName('checkbox');

   for(let i = 0; i < data.length; i++)
   {
       data[i].checked = '';
   }
}

function deleteCanvas()
{
    document.getElementById('canvas').remove();
}

function hiddenBlackBox() {
    document.getElementById('blackBox').setAttribute('hidden', '');
}

function showBlackBox() {
    document.getElementById('blackBox').removeAttribute('hidden');
}

function hiddenMakePhoto() {
    let makePhoto = document.getElementById('makePhoto');

    makePhoto.setAttribute('hidden', '');
}

function showMakePhoto() {
    let makePhoto = document.getElementById('makePhoto');

    makePhoto.removeAttribute('hidden');
}

function hiddenSavePhoto() {
    document.getElementById('savePhoto').setAttribute('hidden', '');
}

function showSavePhoto() {
    let savePhoto = document.getElementById('savePhoto');

    savePhoto.removeAttribute('hidden');
}

function hiddenUploadPhoto() {
    document.getElementById('uploadPhoto').setAttribute('hidden', '');
}

function showUploadPhoto() {
    document.getElementById('uploadPhoto').removeAttribute('hidden');
}

function hiddenTurnCamera() {
    document.getElementById('turnCamera').setAttribute('hidden', '');
}

function showTurnCamera() {
    document.getElementById('turnCamera').removeAttribute('hidden');
}

function hiddenMasks()
{
    document.getElementById('masks_row').setAttribute('hidden', '');
}

function showMasks()
{
    document.getElementById('masks_row').removeAttribute('hidden')
}

function hiddenVideo() {
    let video = document.getElementById('video');
    video.setAttribute('hidden', '');
}

function showVideo() {
    document.getElementById('video').removeAttribute('hidden');
    hiddenBlackBox();
    hiddenTurnCamera();
    hiddenUploadPhoto();
    showMakePhoto();
}

function clearAll()
{
    hiddenVideo();
    showBlackBox();
    showTurnCamera();
    showUploadPhoto();
    hiddenMakePhoto();
    deleteCanvas();
    hiddenSavePhoto();
}