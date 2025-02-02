function newExo(project) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
        if(this.responseText == "New record created successfully") {
            removeReload();
            window.location.href = window.location.href + "&reload=true";
        }
    }
    let str = "?event=exo&name=" + document.getElementById('nameBox').value + "&project=" + project;
  xhttp.open("GET", "newEnter.php"+str);
  xhttp.send(); 
}

function newSession(project) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
        if(this.responseText == "New record created successfully") {
            window.location.reload();
        }
    }
    let str = "?event=session&project=" + project;
  xhttp.open("GET", "newEnter.php"+str);
  xhttp.send(); 
}

function exoPopup() {
    document.getElementById("popup").style.display = "block";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
    removeReload();
  }

function removeReload() {
    var param = "&reload=true";
    let url = window.location.href;
    let urlWithoutParam = url.replace(new RegExp(`[?&]${param}=[^&]*`), "").replace(/&$/, "").replace(/\?$/, "");

    window.location.href = urlWithoutParam;
}