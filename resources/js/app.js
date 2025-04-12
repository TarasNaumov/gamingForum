import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

let menuButton = document.querySelector('.menu-button')
let menu = document.querySelector('.menu')

function toggleMenu () {
    menuButton.classList.toggle('active')
    menu.classList.toggle('active')
}

menuButton.addEventListener('click', toggleMenu)
