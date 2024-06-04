document.addEventListener('DOMContentLoaded', function () {
    const menuTrigger = document.querySelector('.site-header__menu-trigger');
    const body = document.querySelector('body');

    menuTrigger.addEventListener('click', function () {
        body.classList.toggle('no-scroll');
        body.classList.toggle('mobile-menu-active'); 
    });
});
