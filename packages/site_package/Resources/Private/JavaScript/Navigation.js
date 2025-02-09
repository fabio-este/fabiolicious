import $ from 'jquery'
import '../Scss/Navigation.scss'
import Dropdown from 'bootstrap/js/src/dropdown'

$('.dropdown-menu [data-bs-toggle="dropdown"]').on('click', function(e) {

    const submenu = $(this).next(".dropdown-submenu");
    if (!submenu.hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    submenu.toggleClass('show');
    $(this).closest('.dropdown').toggleClass('show');

    $(this).parents('.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $(this).find('.show').removeClass("show");
    });

    return false;
});
