const menuButton = document.getElementById('hamburger-button');
const closeButton = document.getElementById('close-button');
const asideMenu = document.getElementById('aside-menu');
const mainSection = document.getElementById('main-section');
const genresArrayThisYear = [];
const genresArrayAllYears = [];

menuButton.addEventListener('click', (e) => {
    // asideMenu.classList.toggle('hidden');
    asideMenu.classList.toggle('col-12');
    asideMenu.classList.toggle('col-0');
    asideMenu.classList.toggle('d-none');
    asideMenu.classList.toggle('d-flex');
    // asideMenu.classList.toggle('flex-column');
    asideMenu.classList.toggle('d-sm-flex');
    asideMenu.classList.toggle('d-sm-none');

    mainSection.classList.toggle("col-12");
    mainSection.classList.toggle("col-md-10");
    mainSection.classList.toggle("col-sm-8");
});

closeButton.addEventListener('click', (e) => {
    // asideMenu.classList.toggle('hidden');
    asideMenu.classList.toggle('col-12');
    asideMenu.classList.toggle('col-0');
    asideMenu.classList.toggle('d-none');
    asideMenu.classList.toggle('d-flex');
    asideMenu.classList.toggle('flex-column');
    asideMenu.classList.toggle('flex-column');
});