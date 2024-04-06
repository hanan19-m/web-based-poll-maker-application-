
//  calculate and display password strength
function PasswordStrength() {
    var password = document.getElementById("password").value;
    var PasswordStrength = document.getElementById("password-strength");

    //  regular expressions for password 
    var lowercaseRegex = /[a-z]/;
    var uppercaseRegex = /[A-Z]/;
    var digitRegex = /[0-9]/;

    // Checking the password against the regular expressions and calculate the strength
    var strength = 0;
    if (password.match(lowercaseRegex)) {
        strength += 1;
    }
    if (password.match(uppercaseRegex)) {
        strength += 1;
    }
    if (password.match(digitRegex)) {
        strength += 1;
    }

    // Update the password strength indicator based on the calculated strength
   var strength = password.length;

  switch (true) {
    case (strength < 4):
      PasswordStrength.innerHTML = "Weak";
      PasswordStrength.style.color = "red";
      break;
    case (strength >= 4 && strength <= 7):
      PasswordStrength.innerHTML = "Medium";
      PasswordStrength.style.color = "orange";
      break;
    default:
      PasswordStrength.innerHTML = "Strong";
      PasswordStrength.style.color = "green";
      break;
  
    }
}

