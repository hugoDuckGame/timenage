let eventStr;
let events;
let styles  = [null, 'btn-danger', 'btn-warning', 'btn-info', 'btn-success'];

function addEvent(project, session, id, type){
    let cl = document.getElementById(session + "-" + id + "-" + type).classList;
    console.log(cl);
    if (cl.contains('btn-default')){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getEvents(project);
                console.log("created");
            }
        };
        xhttp.open("GET", "new.php?project=" + project + "&session=" + session + "&id=" + id + "&type=" + type, true);
        xhttp.send();
    }
    else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getEvents(project);
                console.log("aaa");
                location.reload();
            }
        };
        xhttp.open("GET", "delete.php?project=" + project + "&session=" + session + "&id=" + id + "&type=" + type, true);
        xhttp.send();
        
    }
}

function getEvents(project){
    console.log("getEvents");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            eventStr = this.responseText;
            events = JSON.parse(eventStr);
            readEvents();
        }
    };
    xhttp.open("GET", "events.php?project=" + project, true);
    xhttp.send();
}

function readEvents() {
    for (let i in events) {
        let session = events[i][0];
        let exo = events[i][1];
        let type = events[i][2];
        let button = document.getElementById(session + "-" + exo + "-" + type)
        button.classList.remove("btn-default");
        button.classList.add(styles[type]);
    }
}