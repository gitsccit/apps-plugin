window.addEventListener('load',fileUploadInit);
document.addEventListener("dragover",fileUploadDragStart);
document.addEventListener("dragend",fileUploadDragStop);
document.addEventListener("dragleave",fileUploadDragStop);
document.addEventListener("mouseout",fileUploadDragStop);

function fileUploadInit() {

    var uploads = document.getElementsByClassName('file-upload');
    for(var i = 0; i < uploads.length; i++) {

        var container = fileUploadContainer(uploads[i]);
        if(container.getAttribute('data-readonly') == "true") {

            var target = fileUploadTarget(uploads[i]);
            if(target)
                target.readOnly = true;

        }
    }
}

function fileUploadClear(obj) {

    // clear the input box
    var target = fileUploadTarget(obj);
    target.value = '';
    if(target.onchange)
        target.onchange();

    // clear any completed uploads
    var list = fileUploadContainer(obj).getElementsByClassName('file-complete');
    for(var i = 0; i < list.length; i++)
        list[i].parentNode.removeChild(list[i]);

}

function fileUploadDragStart() {

    event.preventDefault();
    event.stopPropagation();

    // clear any pending stops
    clearTimeout(fileuploaddragstop);

    // add the upload "screen" element if it does not exist; this fades the screen
    var elements = document.getElementsByClassName('file-upload-screen');
    if(elements.length == 0)
        document.body.insertAdjacentHTML('beforeend','<div class="file-upload-screen" ondrop="fileUploadDragNoDrop(event)"></div>');

    // set the file uploads to active, which pushes their z-index to the top
    var elements = document.getElementsByClassName('file-upload');
    for(var i = 0; i < elements.length; i++)
        elements[i].classList.add('active');

}

var fileuploaddragstop = false;
function fileUploadDragStop() {
    fileuploaddragstop = setTimeout(fileUploadDragStopActual,50);
}
function fileUploadDragStopActual() {
    var elements = document.getElementsByClassName('file-upload-screen');
    for(var i = 0; i < elements.length; i++)
        elements[i].parentNode.removeChild(elements[i]);
    var elements = document.querySelectorAll('.file-upload.active,.file-upload .active');
    for(var i = 0; i < elements.length; i++)
        elements[i].classList.remove('active');
}

function fileUploadDragNoDrop(event) {

    event.preventDefault();
    event.stopPropagation();
    fileUploadDragStop();

}

function fileUploadContainer(obj) {

    var parent = obj;
    while(parent.classList.contains('file-upload') === false)
        parent = parent.parentNode;

    return parent;

}

function fileUploadTarget(obj) {

    var parent = fileUploadContainer(obj);

    var target = parent.getAttribute('data-target');
    if(target) {
        var t = document.querySelector('input[name="'+target+'"]');
        if(t) return t;
    }

    return false;

}

function fileUploadLimit(obj) {

    var target = fileUploadTarget(obj);
    if(target) {
        var name = target.name;
        if(name.substr(-2) == "[]")
            return false; // any number; multiple uploads
    }

    return true;

}

function fileUploadDragDrop(event,object) {

    fileUploadDragNoDrop(event);

    if(fileUploadLimit(object) == 1 && event.dataTransfer.items.length > 1) {
        alert("This form does not support uploading multiple files. Please select a single file and try again.");
        return;
    }

    if( event.dataTransfer.items ) {
        for (var i = 0; i < event.dataTransfer.items.length; i++) {
            var file = event.dataTransfer.items[i].getAsFile();
            fileUploadHandler(file,object);
        }
    }

}

var fileUploadOrigin = false;
function fileUploadLightbox(obj,url) {
    fileUploadOrigin = obj;
    lightbox(url);
}

function fileUploadBrowse(object) {

    if(fileUploadLimit(object) == 1 && object.files.length > 1) {
        alert("This form does not support uploading multiple files. Please select a single file and try again.");
        return;
    }

    if( object.files ) {
        for (var i = 0; i < object.files.length; i++) {
            var file = object.files[i];
            fileUploadHandler(file,object);
        }
    }

}

function fileUploadHandler(file,object) {

    var progressBar = document.createElement('div');
    progressBar.insertAdjacentHTML('beforeEnd','<progress value="0" max="'+file.size+'"></progress><span>'+file.name+'</span>');

    var progress = fileUploadContainer(object).querySelector('.file-progress');
    progress.insertAdjacentElement('beforeEnd',progressBar);


    var xhr = new XMLHttpRequest();
    xhr.progressBar = progressBar;
    xhr.onreadystatechange = function() {
        if(this.readyState == 4) {
            var fileId = parseInt(this.responseText);
            if(isNaN(fileId)) {
                this.progressBar.classList.add('file-error');
                if(this.responseText.length < 120) {
                    this.progressBar.lastChild.innerText += " : " + this.responseText;
                }
            }
            else {
                // response text should contain the ID of the uploaded file
                this.progressBar.parentNode.removeChild(this.progressBar);
                fileAttachFileId(fileId,file.name,object);
            }
        }
    };

    var fileUpload = xhr.upload;
    fileUpload.progressBar = progressBar;
    fileUpload.onprogress = function(e) {
        if(e.lengthComputable) this.progressBar.querySelector('progress').setAttribute('value',e.loaded);
    };

    var formData = new FormData();
    formData.append("upfile",file);
    xhr.open("POST",fileUploadContainer(object).getAttribute('data-upload-url'),true);
    xhr.setRequestHeader("Cache-Control","no-cache");
    xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");
    xhr.setRequestHeader("X-File-Name",encodeURIComponent(file.name));
    xhr.setRequestHeader("X-File-Size",file.size);
    // xhr.setRequestHeader("X-File-Related",listElm.getAttribute('data-related'));
    xhr.setRequestHeader("X-CSRF-Token",fileUploadContainer(object).getAttribute('data-csrf'));
    xhr.setRequestHeader("Content-Type","application/octet-stream");
    xhr.send(formData);

}

function fileAttachFileId(id,name,object) {

    if(object == false)
        if(fileUploadOrigin === false) object = document.querySelector('.file-upload');
        else object = fileUploadOrigin;

    // if the target only supports one attached file
    if(fileUploadLimit(object)) {

        // remove everything in the progress bar group
        fileUploadContainer(object).querySelector('.file-progress').innerHTML = '';

        // set the target's value to the file id
        let obj = fileUploadTarget(object);
        obj.value = id;
        if(obj.onchange)
            obj.onchange();

    }
    else { // multi-input

        var target = fileUploadTarget(object);
        var html = '<input type="hidden" name="' + target.name + '" value="' + id + '">';
        target.insertAdjacentHTML('afterEnd',html);

    }

    // add entry to the file progress container
    var html = '<div class="file-complete"><span>' + name + '</span></div>';
    fileUploadContainer(object).querySelector('.file-progress').insertAdjacentHTML('beforeEnd',html);

}
