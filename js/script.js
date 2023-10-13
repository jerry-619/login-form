var pass = document.getElementById('password');
var strbar = document.getElementById('strength-bar');
var strtxt = document.querySelector('.strength-text');
var cpass = document.getElementById('cpassword');
var mismatch = document.getElementById('mismatch');
var registerBtn = document.getElementById('register');

registerBtn.disabled = true;

let lowerCase, upperCase, numbers, special;
pass.addEventListener("keyup", function () {
  lowerCase = pass.value.match(/[a-z]/);
  upperCase = pass.value.match(/[A-Z]/);
  numbers = pass.value.match(/[0-9]/);
  special = pass.value.match(/[\!\~\@\&\#\$\%\^\&\*\(\)\{\}\?\-\_\+\=]/);
    validate(pass.value, lowerCase, upperCase, numbers, special);
    chkpass();
    btnfunc();
});

pass.addEventListener("focus", function () {
    removeclass("pswd-cri", "hide");

});

pass.addEventListener("blur", function () {
    addclass("pswd-cri", "hide");

});

cpass.addEventListener('focus', chkpass, btnfunc);
cpass.addEventListener('keyup', chkpass, btnfunc);


function validate(pswd, lowerCase, upperCase, numbers, special) {
    let strength = 0;
    if (pswd.length >= 8) {
        addclass("length", "valid");
        removeclass("length", "invalid");

    } else {
        addclass("length", "invalid");
        removeclass("length", "valid");

    }

    if (lowerCase) {
        addclass("small", "valid");
        removeclass("small", "invalid");

    } else {
        addclass("small", "invalid");
        removeclass("small", "valid");

    }

    if (upperCase) {
        addclass("capital", "valid");
        removeclass("capital", "invalid");

    } else {
        addclass("capital", "invalid");
        removeclass("capital", "valid");

    }

    if (numbers) {
        addclass("digit", "valid");
        removeclass("digit", "invalid");

    } else {
        addclass("digit", "invalid");
        removeclass("digit", "valid");

    }

    if (special) {
        addclass("special", "valid");
        removeclass("special", "invalid");

    } else {
        addclass("special", "invalid");
        removeclass("special", "valid");

    }

    if (pswd.length <= 0) {
        clrstrength();
        return false;
    }

    if (pswd.match(/\s/)) {
        setclrtxt("red", "spaces is not allowed");
        return false;
    }

    if (pswd.length < 8) {
        strength = 20;
        setclrtxt("red", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/948086805364867142.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;'></span>too short");
    } else {
        if (lowerCase || upperCase || numbers || special) {
            strength = 40;
            setclrtxt("rgb(243, 104, 104)", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/830485349855395850.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Weak"); // weak
        }

        if (
            (lowerCase && upperCase) || (lowerCase && numbers) || (lowerCase && special) ||
            (upperCase && numbers) || (upperCase && special) || (numbers && special)
        ) {
            strength = 60;
            setclrtxt("orange", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/858553060351148052.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Medium");	// medium		
        }

        if ((lowerCase && upperCase && numbers) || (lowerCase && upperCase && special) ||
            (lowerCase && numbers && special) || (upperCase && numbers && special)
        ) {
            strength = 80;
            setclrtxt("#17cf30", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/893861118899023892.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Strong");	// strong
        }

        if (lowerCase && upperCase && numbers && special) {
            strength = 100;
            setclrtxt("#45f976", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/592316208645275649.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Very Strong");	// very strong
        }
    }
    setstrength(strength);

}

function chkpass() { 
    if(pass.value.length <= 0 && cpass.value.length <= 0){
        mismatch.innerHTML = "";
    }
    else if (pass.value !== cpass.value) {
        mismatch.innerHTML = "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/928948337963597824.gif\");background-size:contain;background-repeat: no-repeat;'></span>Password Mismatched";
        mismatch.style.color = "#c12828";
        registerBtn.disabled = true;
    } else {
        mismatch.innerHTML = "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/857564823172153345.gif\");background-size:contain;background-repeat: no-repeat;'></span>Password Matched"
        mismatch.style.color = "#45f976";
        btnfunc();
    }
}

function btnfunc(){
    if(pass.value == cpass.value && lowerCase && upperCase && numbers && special){
        registerBtn.disabled = false;
    }else{
        registerBtn.disabled = true;
    }

}

function addclass(id, cls) {
    document.getElementById(id).classList.add(cls);
}

function removeclass(id, cls) {
    document.getElementById(id).classList.remove(cls);
}

function setstrength(value) {
    strbar.style.width = value + "%";

}

function setclrtxt(color, text) {
    strbar.style.backgroundColor = color;
    strtxt.innerHTML = text;
    strtxt.style.color = color;
}

function clrstrength() {
    strbar.style.width = 0;
    strbar.style.backgroundColor = "";
    strtxt.innerHTML = "";
}

