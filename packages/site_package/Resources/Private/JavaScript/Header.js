
import {OffCanvas} from 'bootstrap/js/src/offcanvas'
import {Dropdown} from 'bootstrap/js/src/dropdown'
import '../Scss/Header.scss'

const hamburger = document.getElementById('#offCanvasToggler');
const offCanvasMenu = document.getElementById("#offCanvasMenu");
const header = document.getElementById("header.page-header");

offCanvasMenu.on('show.bs.collapse', function () {
    hamburger.addClass('is-active');
});

offCanvasMenu.on('hide.bs.collapse', function () {
    hamburger.removeClass('is-active');
});


