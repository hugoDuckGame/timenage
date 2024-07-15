let time;
var timer;
let resp;
let action;

function hide(classname) {
    var stopButtons = document.getElementsByClassName(classname);
        for (var i = 0; i < stopButtons.length; i++) {
            stopButtons[i].style.display = 'none';
        }
}

function show(classname) {
    var stopButtons = document.getElementsByClassName(classname);
        for (var i = 0; i < stopButtons.length; i++) {
            stopButtons[i].style.display = 'block';
        }
}

function hms(timeInSeconds) {
    var pad = function(num, size) { return ('000' + num).slice(size * -1); },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60),
    minutes = Math.floor(time / 60) % 60,
    seconds = Math.floor(time - minutes * 60),
    milliseconds = time.slice(-3);

    return pad(hours, 2) + ':' + pad(minutes, 2) + ':' + pad(seconds, 2);
}

function seconds(timeInHMS) {
    const [hours, minutes, seconds] = timeInHMS.split(':').map(Number);
    return hours * 3600 + minutes * 60 + seconds;
}

function counter(id) {
    time = getTime(id);
    time = seconds(time);
    console.log("time  : " + time)
    hide('start ' + id);
    show('stop ' + id);
    // This block will be executed 100 times.
    timer = setInterval(function() {
      if (time == 0) {console.log("stopped"); endCount(id)}
      else { console.log('Currently at ' + (time--));
      document.getElementById(id).innerHTML = hms(time);}
    }, 1000);
}

function stopCount(id) {
    clearInterval(timer);
    hide('stop ' + id );
    show('start ' + id);
    time = seconds(document.getElementById(id).innerHTML);
    save(time ,id)
    console.log("stopped" + id)
}

function endCount(id) {
    document.getElementById("alertbox").innerHTML ='<div class="alert alert-warning"> <strong>Your timer has ended.</strong></div>'
    stopCount(id)
}

function save(time, unicid) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log(this.responseText);
    }
    xmlhttp.open("GET", "savetime.php?time=" + time + "&unicid=" + unicid);
    xmlhttp.send();
}

function getTimeDist(unicid) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log("hello")
        console.log(this.responseText);
        time = this.responseText;
    }
    xmlhttp.open("GET", "gettime.php?unicid=" + unicid);
    xmlhttp.send();
}

function getTime(unicid) {
    console.log(document.getElementById(unicid).innerHTML);
    return document.getElementById(unicid).innerHTML;
}

function updateTodo(unicid) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log(this.responseText);
    }
    xmlhttp.open("GET", "checktask.php?id=" + unicid);
    xmlhttp.send();

    console.log(document.getElementById("check-" + unicid).innerHTML, resp)
    if(document.getElementById("check-" + unicid).innerHTML == "Undo") {
        document.getElementById("check-" + unicid).innerHTML = 'Done';
        document.getElementById("check-" + unicid).classList.remove("btn-warning");
        document.getElementById("check-" + unicid).classList.add("btn-success");
        console.log("Undo -> done");
    }
    else {
        document.getElementById("check-" + unicid).innerHTML = 'Undo';
        document.getElementById("check-" + unicid).classList.remove("btn-success");
        document.getElementById("check-" + unicid).classList.add("btn-warning");
        console.log("done -> udno");
    }
}

function showHide(){
    if(document.getElementById("ismult").checked==true) {
        show('number');
    }
    else {
        hide('number');
    }
}

function addTodo(unicid, action) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log("hello")
        console.log(this.responseText);
        time = this.responseText;
    }
    xmlhttp.open("GET", "addremTodo.php?unicid=" + unicid + "&action=" + action);
    xmlhttp.send();
    let val = parseInt(document.getElementById("counter-" + unicid).innerHTML);
    if(action==1) {document.getElementById("counter-" + unicid).innerHTML = val +1 ;}
    else {document.getElementById("counter-" + unicid).innerHTML = val-1 ;};
}

function del(unicid, type) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log("Deleted " + id);
    }
    xmlhttp.open("GET", "delete.php?unicid=" + unicid + "&tbn=" + type, true);
    xmlhttp.send();
    setTimeout(function() {
        location.reload()
      }, 1000);
}

function updateRtn(unicid) {
    if(document.getElementById("check-" + unicid).innerHTML == "Done") {
        action = "c";
    }
    else {
        action = "u"
    }

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log(this.responseText);
    }
    xmlhttp.open("GET", "checkRtn.php?id=" + unicid + "&action=" + action);
    xmlhttp.send();

    console.log(document.getElementById("check-" + unicid).innerHTML, resp)
    if(document.getElementById("check-" + unicid).innerHTML == "Undo") {
        document.getElementById("check-" + unicid).innerHTML = 'Done';
        document.getElementById("check-" + unicid).classList.remove("btn-warning");
        document.getElementById("check-" + unicid).classList.add("btn-success");
        console.log("Undo -> done");
    }
    else {
        document.getElementById("check-" + unicid).innerHTML = 'Undo';
        document.getElementById("check-" + unicid).classList.remove("btn-success");
        document.getElementById("check-" + unicid).classList.add("btn-warning");
        console.log("done -> udno");
    }
    
}