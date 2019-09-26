var navmenueditActiveElement = false;

function navmenueditSelect(obj) {

    if(navmenueditActiveElement)
        navmenueditActiveElement.classList.remove('active');

    if(navmenueditActiveElement === obj) {
        navmenueditEditor(false);
        navmenueditActiveElement = false;
    }
    else navmenueditActiveElement = obj;

    if(navmenueditActiveElement) {
        navmenueditActiveElement.classList.add('active');
        navmenueditEditor(true);
    }

}

function navmenueditEditor(display) {

    let parent = navmenueditActiveElement;
    while(parent.classList.contains('navmenu-edit') === false)
        parent = parent.parentNode;

    let obj = parent.querySelector('.navmenu-fields > div');
    if(display) obj.style.display = 'block';
    else obj.style.display = 'none';

    // load json values
    if(display) {
        let data = JSON.parse( navmenueditActiveElement.querySelector('input').value );
        document.getElementById('navmenu-edit-title').value = data.title;
        document.getElementById('navmenu-edit-destination').value = data.destination;
        document.getElementById('navmenu-edit-htmlid').value = data.htmlid;
        document.getElementById('navmenu-edit-permission').value = data.permission_id;
        document.getElementById('navmenu-edit-file').value = data.file_id;

        // set offset
        let hdiff = navmenueditActiveElement.offsetTop - obj.parentNode.offsetTop;
        let colheight = obj.parentNode.offsetHeight;
        let elmheight = obj.offsetHeight;

        obj.style.marginTop = Math.min(hdiff,colheight - elmheight)+"px";

    }

}

window.addEventListener('keydown',navmenueditKeyDown);
function navmenueditKeyDown() {

    if(navmenueditActiveElement === false)
        return;

    if(event.target && event.target.tagName == 'INPUT')
        return;

    let key = false;
    if(event.key) key = event.key.toLowerCase();
    else if(event.code) key = event.code.toLowerCase();

    if(key == 'arrowright') {
        navmenueditIndent(1);
        event.preventDefault();
    }
    else if(key == 'arrowleft') {
        navmenueditIndent(-1);
        event.preventDefault();
    }
    else if(key == 'arrowdown') {
        navmenueditSort(1);
        event.preventDefault();
    }
    else if(key == 'arrowup') {
        navmenueditSort(-1);
        event.preventDefault();
    }

}

function navmenueditIndent(direction) {

    let min = 0;
    let max = 0;

    if(navmenueditActiveElement.previousElementSibling) {
        let i = parseInt(navmenueditActiveElement.previousElementSibling.getAttribute('data-indent'));
        min = 0;
        max = i + 1;
    }

    // calculate what the new indent should be
    i = parseInt(navmenueditActiveElement.getAttribute('data-indent'));
    let indent = i + direction;
    if(indent < min) indent = min;
    if(indent > max) indent = max;
    if(indent != i) {

        let margin = 40;
        let e = navmenueditActiveElement;
        while(e.classList.contains('navmenu-edit') === false)
            e = e.parentNode;
        margin = parseInt(e.getAttribute('data-margin'));

        navmenueditActiveElement.setAttribute('data-indent',indent);
        navmenueditActiveElement.style.marginLeft = (indent * margin) + "px";

        // update json string
        let input = navmenueditActiveElement.querySelector('input');
        input = JSON.parse(input.value);
        input.indent = indent;
        navmenueditActiveElement.querySelector('input').value = JSON.stringify(input);

    }

}

function navmenueditSort(direction) {

    if(direction > 0) {
        if(navmenueditActiveElement.nextElementSibling)
            navmenueditActiveElement.parentNode.insertBefore(navmenueditActiveElement.nextElementSibling, navmenueditActiveElement);
    }
    else {
        if(navmenueditActiveElement.previousElementSibling)
            navmenueditActiveElement.parentNode.insertBefore(navmenueditActiveElement, navmenueditActiveElement.previousElementSibling);
    }

    navmenueditEditor(true);

}

var navmenueditDefer = false;
function navmenueditKeyDefer() {

    if(navmenueditDefer)
        clearTimeout(navmenueditDefer);

    navmenueditDefer = setTimeout(navmenueditSaveJson,300);

}

var navmenueditAddPosition = 0;
function navmenueditAdd() {

    let data = new Object();
    data.id = false;
    data.indent = 0;
    data.title = "NEW";
    data.destination = "";
    data.htmlid = "";
    data.permission_id = null;
    data.file_id = null;

    var html = '<div class="navmenu-item" data-indent="0" style="margin-left:0px" onclick="navmenueditSelect(this)"><span>NEW</span><input type="hidden" name="applinkNEW'+navmenueditAddPosition+'" value=""></div>';
    var items = document.querySelector('.navmenu-items').insertAdjacentHTML('afterbegin',html);
    document.querySelector('.navmenu-items .navmenu-item:first-child input').value = JSON.stringify(data);
    navmenueditAddPosition++;

    navmenueditSelect( document.querySelector('.navmenu-items .navmenu-item:first-child') );

}

function navmenueditRemove() {

    let input = navmenueditActiveElement.querySelector('input');
    input = JSON.parse(input.value);
    if(input.id) {
        let form = navmenueditActiveElement;
        while(form.tagName.toLowerCase() != 'form')
            form = form.parentNode;
        form.insertAdjacentHTML('beforeend','<input type="hidden" name="applinkdelete[]" value="'+input.id+'">');
    }

    let temp = navmenueditActiveElement;
    let next = temp.nextElementSibling;
    navmenueditSelect(navmenueditActiveElement);
    temp.parentNode.removeChild(temp);

    if(next) {
        navmenueditSelect(next);
        while(next) {
            navmenueditIndent(0);
            next = next.nextElementSibling;
        }
    }

}

function navmenueditSaveJson() {

    if(navmenueditDefer)
        clearTimeout(navmenueditDefer);

    // update json string
    let input = navmenueditActiveElement.querySelector('input');
    input = JSON.parse(input.value);

    input.title = document.getElementById('navmenu-edit-title').value;
    input.destination = document.getElementById('navmenu-edit-destination').value;
    input.htmlid = document.getElementById('navmenu-edit-htmlid').value;
    let p = document.getElementById('navmenu-edit-permission').value;
    let f = document.getElementById('navmenu-edit-file').value;

    if(p.length && isNaN(parseInt(p)))
        document.getElementById('navmenu-edit-permission').value = '';
    else input.permission_id = p;

    if(f.length && isNaN(parseInt(f)))
        document.getElementById('navmenu-edit-file').value = '';
    else input.file_id = f;

    navmenueditActiveElement.firstChild.innerText = input.title
    navmenueditActiveElement.querySelector('input').value = JSON.stringify(input);

}