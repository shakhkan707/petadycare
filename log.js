const signUpBtn = document.getElementById('signUp');
const signInBtn = document.getElementById('signIn');
const container = document.getElementById('container');

signUpBtn.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

signInBtn.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});

document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault(); // отменяем обычную отправку формы

    const formData = new FormData(this);

    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('registerMessage').innerHTML = data;
        this.reset(); // очистка формы
    })
    .catch(error => {
        document.getElementById('registerMessage').innerHTML = 'Ошибка при регистрации.';
        console.error('Ошибка:', error);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        document.getElementById('loginError').textContent = 'Неверное имя пользователя или пароль.';
    }
});


