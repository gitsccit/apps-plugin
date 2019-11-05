function app_nav_toggle() {
    document.body.classList.toggle('collapsed');
    let collapsed = false;
    if (document.body.classList.contains('collapsed')) {
        collapsed = true;
    }
    setCookie("collapsed", collapsed, 30);
    if (typeof priorityTableCalculate == "function") {
        setTimeout(priorityTableCalculate, 300);
    }
}

function app_nav_select(elm, appid, title) {
    // add highlight
    document.querySelector('#apps-navcolumn-1 .active').classList.remove('active');
    elm.parentNode.classList.add('active');
    // change nav
    var list = document.querySelectorAll('#apps-navcolumn-2 .appnav > ul');
    for (var i = 0; i < list.length; i++) list[i].style.display = 'none';
    document.querySelector('#app-submenu-' + appid).style.display = 'block';
    document.getElementById('app-submenu-title').innerText = title;
}

var app_global_search_xhr = false;

function app_global_search_handler(event) {

    event.preventDefault();

    var query = document.getElementById('global-search-input').value.trim();
    var url = document.getElementById('global-search').getAttribute('action');
    url += "?q=" + encodeURIComponent(query);

    // abort any existing submits
    if (app_global_search_xhr)
        app_global_search_xhr.abort();

    // goes nowhere if query is not valid
    if (query.length == 0 || query.length < 3 && isNaN(parseInt(query))) {
        app_global_search_finish(false);
        return false;
    }

    // prepare input elements (adds loading spinner)
    app_global_search_start(query);

    // submit query to the server
    var app_global_search_xhr = new XMLHttpRequest();
    app_global_search_xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            // simulate query time
            app_global_search_finish(this.response);
        }
    };
    app_global_search_xhr.ontimeout = function () {
        app_global_search_finish(false);
    };
    app_global_search_xhr.open("GET", url, true);
    app_global_search_xhr.send();

    return false;

}

function app_global_search_keyup(obj) {

    let value = obj.value.trim();
    if (value.length == 0)
        app_global_search_finish(false);

}

function app_global_search_start(query) {

    var html = '<h6><div class="lds-dual-ring"></div>searching...</h6>';
    document.getElementById('global-search-results').innerHTML = html;
    document.getElementById('global-search-container').classList.add('open');

}

function app_global_search_finish(response) {

    // close the search if response is false
    if (response === false) {
        document.getElementById('global-search-container').classList.remove('open');
        return;
    }

    let results = [];
    if (response.length) {
        let json = JSON.parse(response);
        if (json && json.results.length)
            results = json.results;
    }

    if (results.length == 0) {
        document.getElementById('global-search-results').innerHTML = "<h6>No results were found.</h6>";
        return;
    }

    let html = '';
    for (let i = 0; i < results.length; i++)
        html += '<li><a href="' + results[i].Url + '">' + results[i].Title + '<span>' + results[i].Description + '</span></a></li>';

    document.getElementById('global-search-results').innerHTML = '<ul>' + html + '</ul>';

}


/** PRIORITY TABLES **/
window.addEventListener("resize", priorityTableCalculate);
window.addEventListener("load", priorityTableCalculate);

function priorityTableCalculate() {

    var container = document.getElementById('priority-table');
    if (container == null) return;

    // reset table column visibility
    var temp = container.querySelectorAll('col');
    for (var i = 0; i < temp.length; i++) {
        temp[i].style.visibility = 'visible';
        temp[i].display = 'table-column';
        priorityTableApplyToCells(temp[i]);
    }

    // get container widths
    var container_width = parseInt(container.offsetWidth);

    var table = container.querySelector('table');
    var table_width = parseInt(table.offsetWidth);

    // reduce table size until it fit
    while (table_width > container_width) {

        var obj = priorityTableGetLowestPriority();
        table_width -= priorityTableGetColumnWidth(obj);

        obj.style.visibility = 'collapse';
        obj.style.display = 'none';

        // apply to all column elements; some browsers do not support col (lookin' at you google)
        priorityTableApplyToCells(obj);

    }

}

// gets the lowest priority non-hidden col object
function priorityTableGetLowestPriority() {

    var temp = document.querySelectorAll('#priority-table col');

    var lowest = false;
    var obj = false;
    for (var i = 0; i < temp.length; i++)
        if (temp[i].style.visibility != "collapse") {
            var priority = 0;
            if (typeof temp[i].getAttribute('data-priority') == "string")
                priority = parseInt(temp[i].getAttribute('data-priority'));
            if (priority > lowest) {
                obj = temp[i];
                lowest = priority;
            }
        }

    return obj;

}

function priorityTableGetColumn(obj) {

    var temp = document.querySelectorAll('#priority-table col');
    for (var i = 0; i < temp.length; i++)
        if (temp[i] === obj)
            return i + 1;

    return false;

}

function priorityTableGetColumnWidth(obj) {

    var col = priorityTableGetColumn(obj);
    if (col) {
        var temp = document.querySelector('#priority-table td:nth-child(' + col + ')');
        return parseInt(temp.offsetWidth);
    }

    return false;

}

function priorityTableApplyToCells(obj) {

    var display = "table-cell";
    if (obj.style.visibility == "collapse")
        display = "none";

    var col = priorityTableGetColumn(obj);
    if (col) {
        var temp = document.querySelectorAll('#priority-table th:nth-child(' + col + ')');
        for (var i = 0; i < temp.length; i++) {
            temp[i].style.display = obj.style.visibility;
            temp[i].style.display = display;
        }
        var temp = document.querySelectorAll('#priority-table td:nth-child(' + col + ')');
        for (var i = 0; i < temp.length; i++) {
            temp[i].style.display = obj.style.visibility;
            temp[i].style.display = display;

        }
    }

}

/** TAB LISTS **/
window.addEventListener("load", tabListInitialize);

function tabListInitialize() {

    // set all tab-link to default display
    var temp = document.querySelectorAll('.tab-link');
    for (var i = 0; i < temp.length; i++)
        temp[i].classList.remove('active');

    // set all tab-content to default display
    var temp = document.querySelectorAll('.tab-content');
    for (var i = 0; i < temp.length; i++)
        temp[i].style.display = null;

    // for each tab-list trigger tabListSelect on the first tab
    var temp = document.querySelectorAll('.tab-list .tab-link:first-child');
    for (var i = 0; i < temp.length; i++)
        temp[i].click();

}

function tabListSelect(obj) {

    // do nothing if this tab is currently active
    if (obj.classList.contains('active'))
        return;

    var content = obj.getAttribute('data-content');

    // clear any existing active tabs
    var parent = obj.parentNode;
    var temp = parent.querySelector('.active');
    if (temp) {
        temp.classList.remove('active');
        var c = temp.getAttribute('data-content');
        if (c) {
            var t = document.getElementById(c);
            if (t) t.style.display = null;
        }
    }

    obj.classList.add('active');
    var target = document.getElementById(content);
    if (target) target.style.display = 'block';

}

//https://www.w3schools.com/js/js_cookies.asp
function setCookie(cname, cvalue, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c;
        c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return "";
}

/** LIGHTBOX **/
function lightbox(url) {

    lightboxOrigin = this;

    var wrap = document.body.getElementsByClassName('lightbox-wrap');
    if (wrap.length == 0 && url !== false) {
        // insert the lightbox
        document.body.insertAdjacentHTML('beforeend', '<div class="lightbox-wrap"><div class="lightbox-body"><div class="lightbox-close"><span class="icon-cancel" onclick="lightbox(false)"></span></div><div class="lightbox-content">Loading...</div></div></div>');
    } else if (url === false) {
        // remove the lightbox if the url was false
        if(wrap.length > 0)
            document.body.removeChild(wrap[0]);
        return;
    }

    // proceed with background ajax call
    var body = document.querySelector('.lightbox-content');

    var xhr = new XMLHttpRequest();
    xhr.htmlbody = body;
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {

            // empty the target element
            if(xhr.htmlbody)
                while (xhr.htmlbody.hasChildNodes())
                    xhr.htmlbody.removeChild(xhr.htmlbody.lastChild);

            xhr.htmlbody.insertAdjacentHTML('beforeend', xhr.response);
            lightboxUrlHandler();

        }
    };

    xhr.open("GET", url, true);
    xhr.send();

}

// replaces all links with references to reload the lightbox
function lightboxUrlHandler() {

    var links = document.body.querySelectorAll('.lightbox-content a');
    for (var i = 0; i < links.length; i++) {

        var href = links[i].getAttribute('href');
        if (href.length) {

            links[i].setAttribute('href', 'javascript:void(0)');
            links[i].setAttribute('data-href', href);
            links[i].addEventListener('click', lightboxLink);

        }

    }

    var forms = document.body.querySelectorAll('.lightbox-content form');
    for (var i = 0; i < forms.length; i++) {

        forms[i].addEventListener('submit', lightboxForm);

    }

}

function lightboxLink() {

    var link = this.getAttribute('data-href');
    lightbox(link);

}

function lightboxForm(event) {
    event.preventDefault();

    // proceed with background ajax form submit
    var body = document.querySelector('.lightbox-content');

    var xhr = new XMLHttpRequest();
    xhr.htmlbody = body;
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {

            // empty the target element
            while (xhr.htmlbody.hasChildNodes())
                xhr.htmlbody.removeChild(xhr.htmlbody.lastChild);

            xhr.htmlbody.insertAdjacentHTML('beforeend', xhr.response);
            lightboxUrlHandler();

        }
    };

    var action = this.getAttribute('action');
    var method = this.getAttribute('method');
    if (method != "post") method = "get";

    xhr.open(method, action, true);
    xhr.send(new FormData(this));

    return false;
}

/** Textarea maxlength counter **/
window.addEventListener("load", textareaMaxLengthInitialize);

function textareaMaxLengthInitialize() {
    let elements = document.getElementsByTagName('textarea');
    for (let i = 0; i < elements.length; i++) {
        let max = elements[i].getAttribute('maxlength');
        if (max) max = parseInt(max);
        if (isFinite(max) && max > 0) {
            elements[i].insertAdjacentHTML('afterend', '<div class="textarea-max-length-counter"><div><div></div></div></div>');
            elements[i].nextElementSibling.insertBefore(elements[i], elements[i].nextElementSibling.childNodes[0]);
            elements[i].addEventListener('keyup', textareaMaxLength);
            let event = new Event('keyup');
            elements[i].dispatchEvent(event);
        }
    }
}

function textareaMaxLength() {
    let max = this.getAttribute('maxlength');
    let length = this.value.length;
    this.nextElementSibling.childNodes[0].innerText = length + " of " + max;
}

function url_fix(controller, action) {
    let url = window.location.toString();
    let pos = url.indexOf('/' + controller + '/');
    if (pos)
        url = url.substr(0, pos) + '/' + controller + '/' + action;
    return url;
}
