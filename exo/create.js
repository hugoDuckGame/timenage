
function newProj() {
    let value = document.getElementById('value').value;
    let type = document.getElementById('type').value;
    let subject = document.getElementById('subject').value;
    let theme = document.getElementById('theme').value;
    let chapter = document.getElementById('chapter').value;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        alert(this.responseText);
    }
    let str = "?event=proj&value=" + value + "&type=" + type + "&subject=" + subject + "&theme=" + theme + "&chapter=" + chapter;
  xhttp.open("GET", "newEnter.php"+str);
  xhttp.send(); 
}

document.getElementById("type").addEventListener("input", update);

function update(){
    var subject = document.getElementById("subject");
    var theme = document.getElementById("theme");
    var chapter = document.getElementById("chapter");
    if(document.getElementById("type").value == 1){
        subject.classList.add("hidden");
        theme.classList.add("hidden");
        chapter.classList.add("hidden");
        subject.selectedIndex = 0;
        theme.selectedIndex = 0;
        chapter.selectedIndex = 0;
        value.placeholder = "Name of your subject";
    }
    if(document.getElementById("type").value == 2){
        subject.classList.remove("hidden");
        theme.classList.add("hidden");
        chapter.classList.add("hidden");
        theme.selectedIndex = 0;
        chapter.selectedIndex = 0;
        value.placeholder = "Name of your theme";
    }
    if(document.getElementById("type").value == 3){
        subject.classList.remove("hidden");
        theme.classList.remove("hidden");
        chapter.classList.add("hidden");
        chapter.selectedIndex = 0;
        value.placeholder = "Name of your chapter";
    }
    if(document.getElementById("type").value == 4){
        subject.classList.remove("hidden");
        theme.classList.remove("hidden");
        chapter.classList.remove("hidden");
        value.placeholder = "Name of your other project";
    }
}




