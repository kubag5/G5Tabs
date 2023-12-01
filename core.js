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

function handleSubmitLogin(event) {
  event.preventDefault();
  const login = event.target.elements['login'].value;
  const pass = event.target.elements['pass'].value;
  if (login != null && pass != null && pass.length !== 0 && login.length !== 0) {
    login(login, pass);
  } else {
    showInformation('<span class="error">Błędnie wypełniony formularz.</span>')
  }
}

function handleSubmitRegister(event) {
  event.preventDefault();
  const login = event.target.elements['login'].value;
  const pass = event.target.elements['pass'].value;
  const pass2 = event.target.elements['pass2'].value;
  if (login != null && pass != null && pass.length !== 0 && login.length !== 0 && pass2 === pass) {
    register(login, pass, pass2);
  } else {
    showInformation('<span class="error">Błędnie wypełniony formularz.</span>')
  }

}

function login(login, pass) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          let responseJSON = JSON.parse(xhr.responseText);
          let data = responseJSON.info;
          let js = responseJSON.js;
          let parser = new DOMParser();
          data = parser.parseFromString(data, "text/html");
          showInformation(data.body.innerHTML);
          doJs(js);
      } else {
        showInformation('<span class="error">Błąd połączenia.</span>');
      }
  };
  xhr.open("GET", "login.php?" /*...*/, true);
  xhr.send();
}

function register(login, pass) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          let responseJSON = JSON.parse(xhr.responseText);
          let data = responseJSON.info;
          let js = responseJSON.js;
          let parser = new DOMParser();
          data = parser.parseFromString(data, "text/html");
          showInformation(data.body.innerHTML);
          doJs(js);
      } else {
          showInformation('<span class="error">Błąd połączenia.</span>');
      }
  };
  xhr.open("GET", "register.php?" /*...*/, true);
  xhr.send();
}



function showInformation(inf) {

}

function doJs(js) {

}
