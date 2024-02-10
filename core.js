function generateLighterColor(property, lightenPercentage) {
    const root = getComputedStyle(document.documentElement);
    const originalColor = root.getPropertyValue(property).trim();
  
    const hexToRgb = (hex) => {
      const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
      hex = hex.replace(shorthandRegex, (m, r, g, b) => r + r + g + g + b + b);
      const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      return result
        ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16),
          }
        : null;
    };
  
    const originalRgb = hexToRgb(originalColor);
  
    const lighterRgb = {
      r: Math.min(originalRgb.r + (255 - originalRgb.r) * (lightenPercentage / 100), 255),
      g: Math.min(originalRgb.g + (255 - originalRgb.g) * (lightenPercentage / 100), 255),
      b: Math.min(originalRgb.b + (255 - originalRgb.b) * (lightenPercentage / 100), 255),
    };
  
    const lighterColor = `#${(1 << 24 | lighterRgb.r << 16 | lighterRgb.g << 8 | lighterRgb.b).toString(16).slice(1)}`;
  
    document.documentElement.style.setProperty(property + 'L' + lightenPercentage, lighterColor);
  }

  function genereteVarColors() {
    for (let i = 5; i <= 50; i+=5) {
      generateLighterColor('--kubaVP1' , i); 
      generateLighterColor('--kubaVP2' , i); 
      generateLighterColor('--kubaVP3' , i); 
    }
  }

genereteVarColors();

let login = true;
function changeLRG() {
  login = !login;
  return updateLRG();
}

function updateLRG() {
  if (document.getElementById("registerform") == null) {
    return;
  }
  if (login) document.getElementById("registerform").style.display = "none";
  if (!login) document.getElementById("loginform").style.display = "none";

  if (!login) document.getElementById("registerform").style.display = "block";
  if (login) document.getElementById("loginform").style.display = "block";

  let text = "chce się ";
  if (login) text += "zarejestrować"; 
  if (!login) text += "zalogować"; 
  document.getElementById("LRGBT").innerText = text;
  return login;
}

updateLRG();


class Alert {
  constructor(title, description) {
    this.title = title;
    this.description = description;
  }
}

let alertQueue = [];
let isAlertDisplayed = false;

function addAlert(title, description) {
  if (title != null && description != null && alertQueue.length < 6)
  alertQueue.push(new Alert(title, description));
}

function displayAlert() {
  if (!isAlertDisplayed && alertQueue.length > 0) {
    isAlertDisplayed = true;
    const { title, description } = alertQueue.shift();
    const alertElement = document.createElement('div');
    alertElement.classList.add('alert');
    alertElement.innerHTML = `<h2>${title}</h2>` + breakText(description, 30);
    document.body.appendChild(alertElement);

    setTimeout(() => {
      document.body.removeChild(alertElement);
      isAlertDisplayed = false; 
    }, 5000); 
  }
}

function breakText(text, count) {
  var newText = '';
  var a = 0;
  for (var i = 0; i < text.length; i++) {
    newText += text[i];
      if (a >= count && text[i] === ' ') {
        a = 0;
        newText += text[i] + '<br>';
      }
    a++;
  }
  return newText;
}

setInterval(() => {
  displayAlert();
}, 500);

let isRegORLog = false;

function handleSubmitLogin(event) {
  event.preventDefault();
  if (isRegORLog == true) {
    return;
  }
  isRegORLog = true;
  document.getElementById("LRGBT").setAttribute("disabled", "");
  const login = event.target.elements['login'].value;
  const pass = event.target.elements['pass'].value;
  if (login != null && pass != null && pass.length !== 0 && login.length !== 0) {
    loginUser(login, pass);
  } else {
    showInformation('<span class="error">Błędnie wypełniony formularz.</span>');
    doJs(-1);
  }
}

function handleSubmitRegister(event) {
  event.preventDefault();
  if (isRegORLog) {
    return;
  }
  isRegORLog = true;
  document.getElementById("LRGBT").setAttribute("disabled", "");
  const login = event.target.elements['login'].value;
  const pass = event.target.elements['pass'].value;
  const pass2 = event.target.elements['pass2'].value;
  if (login != null && pass != null && pass.length !== 0 && login.length !== 0 && pass2 === pass && login.length < 51) {
    register(login, pass, pass2);
  } else {
    showInformation('<span class="error">Błędnie wypełniony formularz.</span>');
    doJs(-1);
  }

}

function loginUser(login, pass) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        let responseJSON = JSON.parse(xhr.responseText);
        let data = responseJSON.info;
        let js = responseJSON.js;
        let parser = new DOMParser();
        data = parser.parseFromString(data, "text/html");
        showInformation(data.body.innerHTML);
        doJs(js);
    } else {
     showInformation('<span class="error">Błąd połączenia.</span>');
     doJs(-1);
    }
    }
  };
  xhr.open("GET", "actionManager.php?action=0&A01=" + login + "&A02=" + pass, true);
  xhr.send();
}

function register(login, pass) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
          let responseJSON = JSON.parse(xhr.responseText);
          let data = responseJSON.info;
          let js = responseJSON.js;
          let parser = new DOMParser();
          data = parser.parseFromString(data, "text/html");
          showInformation(data.body.innerHTML);
          doJs(js);
      } else {
          showInformation('<span class="error">Błąd połączenia.</span>');
          doJs(-1);
      }
    }
  };
  xhr.open("GET", "actionManager.php?action=1&A01=" + login + "&A02=" + pass, true);
  xhr.send();
}



function showInformation(inf) {
  if (inf != null) {
    addAlert("Informacja", inf);
    if (document.getElementById("information-box") != null) {
      document.getElementById("information-box").innerHTML = breakText(inf, 20);
    }  
  }
}

function doJs(js) {
  // funkcja do wywołania wcześniej przygotowanych js.

    if (js == -1) {
      const loginpanel = document.getElementById("loginpanel");
      if (!loginpanel.classList.contains("border-error") && !loginpanel.classList.contains("border-done")) {
        document.getElementById("loginpanel").classList.add("border-error");
        setTimeout(() => {
        document.getElementById("loginpanel").classList.remove("border-error");
        document.getElementById("LRGBT").removeAttribute("disabled");
        isRegORLog = false;
        }, 4900);
      }

    }


    if (js == 0) {
      const loginpanel = document.getElementById("loginpanel");
      if (!loginpanel.classList.contains("border-error") && !loginpanel.classList.contains("border-done")) {
        document.getElementById("loginpanel").classList.add("border-done");
        setTimeout(() => {
        document.getElementById("loginpanel").classList.remove("border-done");
        document.location.reload();
        }, 4900);
      }

    }


    if (js == 1) {
      const loginpanel = document.getElementById("loginpanel");
      login = true;
      updateLRG();
      if (!loginpanel.classList.contains("border-error") && !loginpanel.classList.contains("border-done")) {
        document.getElementById("loginpanel").classList.add("border-done");
        setTimeout(() => {
        document.getElementById("loginpanel").classList.remove("border-done");
        document.getElementById("LRGBT").removeAttribute("disabled");
        isRegORLog = false;
        }, 4900);
      }
      }
      
}


let edit = false;
function editMode() {
  leaveWarn1 = true;
  document.getElementById("content").innerHTML = "wczytywanie...";
  if (typeof json !== 'undefined') {
    edit = true;
    let cn = "";
    cn += "<h1>Edytujesz: "+json.name+" </h1>"
    if (typeof json.daty !== 'undefined') { 
      json.daty.sort((a, b) => {
        const dateA = parseDate(a.data);
        const dateB = parseDate(b.data);
        return dateA - dateB;
      });
      let i = 0;
      json.daty.forEach(element => {
        if (typeof element.data !== 'undefined' || typeof element.text !== 'undefined') { 
          cn +=  "<div class='tabs1editmode'> TEXT: "+ element.text + " DATA: "+ element.data +" | <a onclick='deleteBox("+i+")'>USUŃ</a> </div>";
        } else {
          deleteBox(i);
        }
        i++;
      });
    }
    cn += "<br/><hr/><br/> <h2>Dodaj: </h2>";
    cn += `
    <form onsubmit="handleSubmitEditAdd(event)" class="otherFrom">
    <label for="date">Data:</label>
    <input type="date" name="date" class='LRGI' required><br/><br/>
    <label for="tekst">Tekst:</label>
    <input type="text" id="tekst" name="tekst" class='LRGI' maxlength='300' required> 
    <br/><br/><br/>
    <button type="submit" class='LRGBI'>Dodaj</button>
    </form>
    `
    cn += "<br/><hr/><br/> <h2>Opcje: </h2><br/>";
    cn += "<button class='choose-bt' onclick='saveJson()'> Zapisz </button><br/><br/>";
    cn += "<a class='choose-bt' href='tabs/?id="+projectID+"'>Zobacz</a><br/><br/>";
    cn += "<button class='choose-bt' onclick='deleteTab()'> Usuń cały TAB</button><br/><br/><br/>";

    document.getElementById("content").innerHTML = cn;
  }
}

function deleteBox(index) {
  if (!confirm("Czy aby napewno chcesz usunąć box'a?")) return;
  if (index >= 0 && index < json.daty.length) {
    json.daty.splice(index, 1);
    editMode();
  }
}
let leaveWarn1 = false;
function saveJson() {
  leaveWarn1 = false;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        let responseJSON = JSON.parse(xhr.responseText);
        let data = responseJSON.info;
        let parser = new DOMParser();
        data = parser.parseFromString(data, "text/html");
        showInformation(data.body.innerHTML);
    } else {
     showInformation('<span class="error">Błąd połączenia.</span>');
    }
    }
  };
  xhr.open("GET", "actionManager.php?action=2&A01="  + projectID + "&A02=" + JSON.stringify(json), true);
  xhr.send();
}

let months = ["STY", "LUT", "MAR", "KWI", "MAJ", "CZE", "LIP", "SIE", "WRZ", "PAŹ", "LIS", "GRU"];
function parseDate(dateString) {
  const parts = dateString.split(' ');
  const day = parseInt(parts[0], 10);
  const month = months.indexOf(parts[1]);
  const year = parseInt(parts[2], 10);
  return new Date(year, month, day);
}


function handleSubmitEditAdd(event) {
  event.preventDefault();
  const date = event.target.elements['date'].value;
  const [rok, miesiac, dzien] = date.split('-').map(Number);
  const tekst = event.target.elements['tekst'].value;
  const data = dzien + " " + months[miesiac-1] + " " + rok;
  const newDate = { text: tekst, data: data };
  json.daty.push(newDate);
  editMode();
}

function deleteTab() {
  if (!confirm("Czy aby napewno chcesz usunąć całego TABA?")) return;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        let responseJSON = JSON.parse(xhr.responseText);
        let data = responseJSON.info;
        let parser = new DOMParser();
        data = parser.parseFromString(data, "text/html");
        showInformation(data.body.innerHTML);
        window.location.replace("index.php");
    } else {
     showInformation('<span class="error">Błąd połączenia.</span>');
    }
    }
  };
  xhr.open("GET", "actionManager.php?action=3&A01="  + projectID, true);
  xhr.send();
}

function addTab() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        let responseJSON = JSON.parse(xhr.responseText);
        let data = responseJSON.info;
        let parser = new DOMParser();
        data = parser.parseFromString(data, "text/html");
        showInformation(data.body.innerHTML);
        let js = responseJSON.js;
        if (js != 2) {
          location.reload();
        }
    } else {
     showInformation('<span class="error">Błąd połączenia.</span>');
    }
    }
  };
  xhr.open("GET", "actionManager.php?action=4", true);
  xhr.send();
}
function changeStyle(id) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        location.reload();
    } else {
     showInformation('<span class="error">Błąd połączenia.</span>');
    }
    }
  };
  xhr.open("GET", "actionManager.php?action=5&A01=" + id, true);
  xhr.send();
}

window.onbeforeunload = function () { 
  if(leaveWarn1) {
    return "Dokonałes niezapisanych zmian. Czy chcesz anulować?"
  }
}