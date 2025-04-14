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

