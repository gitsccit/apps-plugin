window.addEventListener("load", optionInitialize);

function optionInitialize() {
    let elm = document.getElementById('type');
    if(elm) {
        elm.addEventListener('change',optionValue);
        let event = new Event('change');
        elm.dispatchEvent(event);
    }
}

function optionValue() {

    let type = this.options[this.selectedIndex].value;
    let value = document.getElementById('value');

    let t = 'text';
    if(type == 'email')
        t = 'email';

    let d = 'none';
    let r = false;
    if(type == 'file') {
        d = 'block';
        r = true;
    }

    // set all file-uploads display properties
    let objects = document.getElementsByClassName('file-upload');
    for(let i = 0; i < objects.length; i++) {
        objects[i].parentNode.style.display = d;
        let x = fileUploadTarget(objects[i]);
        x.type = t;

        if(x.readOnly != r)
          x.readOnly = r;

        if(type == 'file' && isNaN(x.value))
            x.value = '';
    }

}