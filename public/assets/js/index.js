// const axios = require('axios');

var email_error = document.getElementById('email_error');
var pasword_error = document.getElementById('password_error');
var captcha_error = document.getElementById('captcha_error');

var email = document.getElementById('email');
var passowrd = document.getElementById('password');
var captcha = document.getElementById('captcha');
var captcha_image = document.getElementById('captcha_image');
var csrfValue = document.getElementById('csrf').value;

var change_captcha_button = document.getElementById('change_captcha');

email.addEventListener('input', (event) => {
	console.log(event.target.value);

    var bodyFormData = new FormData();
    bodyFormData.append('email', event.target.value);
    bodyFormData.append('password', '');
    bodyFormData.append('csrf', csrfValue);

    axios.post('/form_submit', bodyFormData)
    .then(function (response) {
        console.log((response.data.email), '-----------');
        if (response.data.email) {
            email.classList.add("is-invalid");
            email_error.innerHTML = response.data.email;
        } else {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            email_error.innerHTML = '';
        }
        // console.log(email);
    })
    .catch(function (error) {
        console.log(error);
    });
});


password.addEventListener('input', (event) => {
	console.log(event.target.value);

    var bodyFormData = new FormData();
    bodyFormData.append('email', '');
    bodyFormData.append('password', event.target.value);
    bodyFormData.append('csrf', csrfValue);

    axios.post('/form_submit', bodyFormData)
    .then(function (response) {
        console.log((response.data.password), '-----------');
        if (response.data.password) {
            password.classList.add("is-invalid");
            password_error.innerHTML = 'Password should be at least 4 caracter.';
        } else {
            password.classList.remove("is-invalid");
            password.classList.add("is-valid");
            password_error.innerHTML = '';
        }
        // console.log(email);
    })
    .catch(function (error) {
        console.log(error);
    });
});

document.getElementById("form_register").addEventListener("click", (event) => {
	event.preventDefault();
	console.log('Form Submitted!');

    var emailValue = document.getElementById('email').value;
    var passwordValue = document.getElementById('password').value;
    var captchaValue = document.getElementById('captcha').value;
    var csrfValue = document.getElementById('csrf').value;

    var bodyFormData = new FormData();

    bodyFormData.append('email', emailValue);
    bodyFormData.append('password', passwordValue);
    bodyFormData.append('captcha', captchaValue);
    bodyFormData.append('csrf', csrfValue);

    axiosPost(bodyFormData);
});

function axiosPost (bodyFormData) {
    axios.post('/form_submit', bodyFormData)
    .then(function (response) {
        if (response.data.csrf) {
            alert('419 Page has been expired. Please refresh the page.');
            return;
        }

        if (response.data.email) {
            email.classList.add("is-invalid");
            email_error.innerHTML = response.data.email;
        } else {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            email_error.innerHTML = '';
        }

        if (response.data.password) {
            password.classList.add("is-invalid");
            password_error.innerHTML = 'Password should be at least 4 caracter.';
        } else {
            password.classList.remove("is-invalid");
            password.classList.add("is-valid");
            password_error.innerHTML = '';
        }

        if (response.data.captcha) {
            captcha.style = 'border: 3px solid red';
            captcha_error.innerHTML = 'Wrong captcha';
        } else {
            captcha.classList.remove("is-invalid");
            captcha.classList.add("is-valid");
            captcha_error.innerHTML = '';
        }

        if (response.data.auth == true) {
            localStorage.setItem('tocken', response.data.tocken);
            localStorage.setItem('auth_user_id', response.data.auth_user_id);
            var now = new Date();
            var time = now.getTime();
            var expireTime = time + 60*60*1000;
            now.setTime(expireTime);
            document.cookie = 'tocken=' + response.data.tocken + ';expires=' + now.toUTCString();
            window.location.href = "/home_page";
        }

    })
    .catch(function (error) {
        console.log(error);
    });
}

change_captcha_button.addEventListener('click', function (event) {
    event.preventDefault();
    console.log(2234234);

    axios.get('/reset_captcha')
    .then(function (response) {
        console.log(response);
        captcha_image.src = response.data;
    })
    .catch(function (error) {
        console.log(error);
    })
});

