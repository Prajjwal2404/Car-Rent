
const wrapper = document.querySelector('.wrapper');
const wrapperA = document.querySelector('.wrapper-a');
const wrapperAdd = document.querySelector('.add');
const wrapperEdit = document.querySelector('.edit');
const wrapperRent = document.querySelector('.rent');


function registerLink() {
    wrapper.classList.add('active');
}

function loginLink() {
    wrapper.classList.remove('active');
}

function forgotLink() {
    wrapper.classList.add('active-pass');
}

function backLink() {
    wrapper.classList.remove('active-pass');
}

function loginPopup() {
    window.scrollTo(0, 0);
    wrapper.style.display = "flex";
    setTimeout(() => wrapper.style.transform = "scale(1)", 100);
}

function iconClose() {
    wrapper.style.transform = "scale(0)";
    setTimeout(() => wrapper.style.display = "none", 500);
}



function addPopup() {
    window.scrollTo(0, 0);
    wrapperAdd.style.display = "flex";
    setTimeout(() => wrapperAdd.style.transform = "scale(1)", 100);
}

function iconCloseAdd() {
    wrapperAdd.style.transform = "scale(0)";
    setTimeout(() => wrapperAdd.style.display = "none", 500);
}



function editPopup(id) {
    window.scrollTo(0, 0);
    wrapperEdit.style.display = "flex";
    setTimeout(() => wrapperEdit.style.transform = "scale(1)", 100);
    document.getElementById('model').value = id.Model;
    document.getElementById('number').value = id.Number;
    document.getElementById('seating').value = id.Seating;
    document.getElementById('rent').value = id.Rent;
    document.getElementById('carId').value = id.CarID;
}

function iconCloseEdit() {
    wrapperEdit.style.transform = "scale(0)";
    setTimeout(() => wrapperEdit.style.display = "none", 500);
}



function rentPopup(id) {
    window.scrollTo(0, 0);
    if (getCookie('UID')) {
        wrapperRent.style.display = "flex";
        setTimeout(() => wrapperRent.style.transform = "scale(1)", 100);
        document.getElementById('carID').value = id.CarID;
        document.getElementById('agencyId').value = id.AgencyID;
        document.getElementById('UID').value = getCookie('UID');
    }
    else loginPopup()
}

function iconCloseRent() {
    wrapperRent.style.transform = "scale(0)";
    setTimeout(() => wrapperRent.style.display = "none", 500);
}



function accountPopup() {
    window.scrollTo(0, 0);
    wrapperA.style.display = "flex";
    setTimeout(() => wrapperA.style.transform = "scale(1)", 100);
}

function iconCloseA() {
    wrapperA.style.transform = "scale(0)";
    setTimeout(() => wrapperA.style.display = "none", 500);
}

function logout() {
    document.cookie = "UID=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "Category=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    location.href = "index.php";
}



function disable() {
    if (getCookie('Category') === 'caragency_login') {
        Array.from(document.getElementsByClassName('rent-btn')).forEach(element => {
            element.classList.add('disabled')
        });
    }
}
disable()



function getCookie(cookieName) {
    const cookies = document.cookie.split('; ');

    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];

        if (cookie.startsWith(cookieName + '=')) {
            return cookie.slice(cookieName.length + 1);
        }
    }

    return undefined;
}



function otp() {
    let mail = document.getElementById('pass-mail').value;
    if (mail == '') {
        alert("Please enter an Email");
    } else {
        Array.from(document.getElementsByName('resetType')).forEach(el => {
            if (el.checked) {
                document.cookie = "passCategory =" + el.value;
            }
        })
        document.cookie = "passMail =" + mail;
        $.ajax({
            url: 'otp.php',
            success: function (resp) {
                document.cookie = "passCategory=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "passMail=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                if (resp == 0) {
                    alert('OTP sent to your registered email\n\nResend OTP again in 30 seconds');
                    document.querySelector('.otp-push').classList.add('sent');
                    setTimeout(() => document.querySelector('.otp-push').classList.remove('sent'), 30000);
                } else if (resp == 1) {
                    alert('Unable to send OTP, please retry');
                }
                else if (resp == 2) {
                    alert('Email does not exist');
                }
            }
        });
    }
}