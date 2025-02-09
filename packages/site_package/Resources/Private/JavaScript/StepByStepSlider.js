'use strict';

import $ from 'jquery'
import slick from 'slick-carousel'

import '../Scss/Slider.scss';

$('.step-by-step-container.slider').slick({
    arrows: false,
    slidesToShow: 1,
});
