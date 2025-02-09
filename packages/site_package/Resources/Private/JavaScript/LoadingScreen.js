'use strict';

import '../Scss/LoadingScreen.scss';

const loadingScreen = document.querySelector('#loading-screen'),
    subListing = document.querySelectorAll('.subcategory-listing'),
    icalDownloadButton = document.querySelector('.btn-ical-download');

    console.log(icalDownloadButton);

if (icalDownloadButton !== null && icalDownloadButton.length > 0) {
    icalDownloadButton.addEventListener("click", function () {
      alert('icalDownloadButton');
    loadingScreen.remove();
  });
}

if(subListing.length > 0){
    loadingScreen.remove();
}else{
    window.addEventListener('pageshow', (event) => {
        loadingScreen.classList.remove('fade-in');
        loadingScreen.classList.add('fade-out');
    });

    window.addEventListener('beforeunload', (event) => {

        // don't show loading screen when download button is clicked
        let activeElement = event.target.activeElement;
        if (!activeElement.classList.contains("btn-ical-download")) {    
            
            // fade in LoadingScreen
            loadingScreen.classList.remove("fade-out");
            loadingScreen.classList.add("fade-in");
        }
    });

    document.getElementById('.no-loading-screen').click(function () {
        loadingScreen.hide();
    });
}
