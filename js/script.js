const nav = document.getElementsByTagName('nav')[0];
const nav_op = document.getElementById('nav_op');
const nav_close = document.getElementById('nav_close');

const all = document.getElementsByTagName('body')[0];

function openNav() {
    nav.classList.add('nav-active');
    all.style['overflow-y'] = 'hidden';
}

function closeNav() {
    nav.classList.remove('nav-active');
    all.style['overflow-y'] = 'scroll';
}

nav_op.addEventListener('click', openNav);
nav_close.addEventListener('click', closeNav);


const cat_full_mov = document.getElementById('category_full-movies');
const cat_full_ser = document.getElementById('category_full-series');

function openSubsMov() {
    cat_full_mov.classList.toggle('subcategory-active');
}

function openSubsSer() {
    cat_full_ser.classList.toggle('subcategory-active');
}

cat_full_mov.addEventListener('click', openSubsMov);
cat_full_ser.addEventListener('click', openSubsSer);