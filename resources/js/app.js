import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.querySelectorAll('.topic_setting_button').forEach(button => {
    button.addEventListener('click', function () {
        const topic = button.closest('.topic')
        const setting = topic.querySelector('.topic_setting')

        button.classList.toggle('active')
        setting.classList.toggle('active')
    })
})


let menuButton = document.querySelector('.menu-button')
let menu = document.querySelector('.menu')

if (menuButton && menu) {
    function toggleMenu() {
        menuButton.classList.toggle('active')
        menu.classList.toggle('active')
    }

    menuButton.addEventListener('click', toggleMenu)
}

document.querySelectorAll('.select_no_submit').forEach(select => {
    select.addEventListener('change', function () {
        this.closest('form').submit();
    });
});

document.getElementById('avatarInput').addEventListener('change', function () {
    if (this.files.length > 0) {
        this.closest('form').submit()
    }
});

