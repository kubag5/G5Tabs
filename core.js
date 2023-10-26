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
    for (let i = 1; i <= 50; i++) {
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