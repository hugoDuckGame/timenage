var timer;
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
    var a = timeInHMS.split(':'); // split it at the colons
    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);   
    return seconds;
}

function counter(i, id) {
    hide('start ' + id);
    show('stop ' + id);
    // This block will be executed 100 times.
    timer = setInterval(function() {
      if (i == 0) { clearInterval(this); console.log("stopped"); }
      else { console.log('Currently at ' + (i--));
      document.getElementById(id).innerHTML = hms(i);}
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

function save(time, unicid) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log(this.responseText);
    }
    xmlhttp.open("GET", "savetime.php?time=" + time + "&unicid=" + unicid);
    xmlhttp.send();
}