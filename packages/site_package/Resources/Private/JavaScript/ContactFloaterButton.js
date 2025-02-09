'use strict';


const floater = document.querySelector('#contactFloater');
const button = floater.querySelector('#contactFloaterButton');
const closeButton = floater.querySelector('#contactFloaterCloseButton');
const content = floater.querySelector('#contactFloaterContent');
const newsletterButton = floater.querySelector('a#newsletter-link');
const newsletterForm = document.querySelectorAll('.footer-intro form[id^=\'newsletter-optin-\']')[0];



button.addEventListener('click', function () {
    button.classList.toggle("hidden");
    content.classList.toggle("hidden");
});

newsletterButton.addEventListener('click', function (event) {
    event.preventDefault();
    newsletterForm.scrollIntoView({behavior: "smooth", block: "center"});
});

closeButton.addEventListener('click', function () {
    button.classList.remove("hidden");
    content.classList.add("hidden");
});

