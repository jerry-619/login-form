document.addEventListener('DOMContentLoaded', function() {
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
    }
    
    initializeInteractiveElements();
    initializeFormValidation();
});

var pass = document.getElementById('password');
var strbar = document.getElementById('strength-bar');
var strtxt = document.querySelector('.strength-text');
var cpass = document.getElementById('cpassword');
var mismatch = document.getElementById('mismatch');
var registerBtn = document.getElementById('register');

if (registerBtn) {
    registerBtn.disabled = true;
}

let lowerCase, upperCase, numbers, special;

if (pass) {
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
}

if (cpass) {
    cpass.addEventListener('focus', chkpass, btnfunc);
    cpass.addEventListener('keyup', chkpass, btnfunc);
}


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
                setclrtxt("rgb(243, 104, 104)", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/830485349855395850.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Weak");
            }

        if (
            (lowerCase && upperCase) || (lowerCase && numbers) || (lowerCase && special) ||
            (upperCase && numbers) || (upperCase && special) || (numbers && special)
            ) {
                strength = 60;
                setclrtxt("orange", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/858553060351148052.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Medium");
            }

        if ((lowerCase && upperCase && numbers) || (lowerCase && upperCase && special) ||
            (lowerCase && numbers && special) || (upperCase && numbers && special)
            ) {
                strength = 80;
                setclrtxt("#17cf30", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/893861118899023892.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Strong");
            }

            if (lowerCase && upperCase && numbers && special) {
                strength = 100;
                setclrtxt("#45f976", "<span style='display: inline-flex;width: 20px;height: 20px;background-image: url(\"https://cdn.discordapp.com/emojis/592316208645275649.gif\");background-size:contain;background-repeat: no-repeat;padding-left: 28px;''></span>Very Strong");
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

function initializeInteractiveElements() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('loading')) {
                submitBtn.classList.add('loading');
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                }, 3000);
            }
        });
    });
    
    const passwordFields = document.querySelectorAll('input[type="password"]');
    passwordFields.forEach(field => {
        const existingToggle = field.parentElement.querySelector('.password-toggle-icon');
        
        if (!existingToggle) {
            field.parentElement.style.position = 'relative';
            
            const toggleBtn = document.createElement('i');
            toggleBtn.className = 'fas fa-eye password-toggle-icon';
            toggleBtn.setAttribute('aria-label', 'Toggle password visibility');
            toggleBtn.setAttribute('role', 'button');
            toggleBtn.setAttribute('tabindex', '0');
            
            toggleBtn.addEventListener('click', function() {
                togglePasswordVisibility(field, toggleBtn);
            });
            
            toggleBtn.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    togglePasswordVisibility(field, toggleBtn);
                }
            });
            
            field.parentElement.appendChild(toggleBtn);
        }
    });

    const buttons = document.querySelectorAll('.input-submit, input.login, input.register, .add-user-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                pointer-events: none;
                animation: ripple 0.6s ease-out;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    const alerts = document.querySelectorAll('.alert, .em-exist');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    });
}

function togglePasswordVisibility(field, toggleBtn) {
    if (field.type === 'password') {
        field.type = 'text';
        toggleBtn.className = 'fas fa-eye-slash password-toggle-icon';
        toggleBtn.setAttribute('aria-label', 'Hide password');
    } else {
        field.type = 'password';
        toggleBtn.className = 'fas fa-eye password-toggle-icon';
        toggleBtn.setAttribute('aria-label', 'Show password');
    }
}

function initializeFormValidation() {
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.style.border = '2px solid #c12828';
                showValidationMessage(this, 'Please enter a valid email address');
            } else {
                this.style.border = 'none';
                hideValidationMessage(this);
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.border = 'none';
            hideValidationMessage(this);
        });
    });
    
    const usernameInputs = document.querySelectorAll('input[name="username"]');
    usernameInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length > 0 && this.value.length < 3) {
                showValidationMessage(this, 'Username must be at least 3 characters');
            } else {
                hideValidationMessage(this);
            }
        });
    });
    
    const checkboxes = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    checkboxes.forEach(input => {
        input.addEventListener('change', function() {
            const label = this.closest('label');
            if (label) {
                if (this.checked) {
                    label.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                }
            }
        });
    });
}

function showValidationMessage(input, message) {
    hideValidationMessage(input);
    const msgElement = document.createElement('div');
    msgElement.className = 'validation-message';
    msgElement.textContent = message;
    msgElement.style.cssText = `
        color: #c12828;
        font-size: 12px;
        margin-top: 5px;
        animation: fadeIn 0.3s ease;
    `;
    input.parentElement.appendChild(msgElement);
}

function hideValidationMessage(input) {
    const existingMsg = input.parentElement.querySelector('.validation-message');
    if (existingMsg) {
        existingMsg.remove();
    }
}

if (!document.getElementById('ripple-animation')) {
    const style = document.createElement('style');
    style.id = 'ripple-animation';
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
        
        .touch-device .input-box:focus {
            transform: scale(1);
        }
    `;
    document.head.appendChild(style);
}

document.addEventListener('DOMContentLoaded', function() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        const today = new Date().toISOString().split('T')[0];
        input.setAttribute('max', today);
        
input.addEventListener('change', function() {
            this.style.color = '#8993d6';
            this.style.fontWeight = '600';
            setTimeout(() => {
                this.style.color = '#040404';
                this.style.fontWeight = 'normal';
            }, 300);
        });
    });
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach((input, index) => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && this.type !== 'submit' && this.tagName !== 'TEXTAREA') {
                e.preventDefault();
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
    });
});

setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (alert.querySelector('.btn-close')) {
            setTimeout(() => {
                const closeBtn = alert.querySelector('.btn-close');
                if (closeBtn) {
                    alert.style.transition = 'all 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        }
    });
}, 1000);

window.addEventListener('online', function() {
    showNetworkStatus('You are back online!', 'success');
});

window.addEventListener('offline', function() {
    showNetworkStatus('You are offline!', 'danger');
});

function showNetworkStatus(message, type) {
    const existing = document.querySelector('.network-status');
    if (existing) existing.remove();
    
    const statusDiv = document.createElement('div');
    statusDiv.className = `alert alert-${type} network-status`;
    statusDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
        animation: slideInRight 0.5s ease;
    `;
    statusDiv.textContent = message;
    document.body.appendChild(statusDiv);
    
    setTimeout(() => {
        statusDiv.style.opacity = '0';
        statusDiv.style.transform = 'translateX(100%)';
        setTimeout(() => statusDiv.remove(), 500);
    }, 3000);
}

if (!document.getElementById('network-status-animation')) {
    const style = document.createElement('style');
    style.id = 'network-status-animation';
    style.textContent = `
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
}

