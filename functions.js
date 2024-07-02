function hide(classname, id) {
    var stopButtons = document.getElementsByClassName(classname + " " + id);
    stopButtons[i].style.display = 'none';
}

function show(classname, id) {
    var stopButtons = document.getElementsByClassName(classname + " " + id);
    stopButtons[i].style.display = 'block';
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

function counter(i, id) {
    hide('start', id);
    show('stop', id);
    // This block will be executed 100 times.
    setInterval(function() {
      if (i == 0) clearInterval(this);
      else console.log('Currently at ' + (i--));
      document.getElementById(id).innerHTML = hms(i);
    }, 1000);
}