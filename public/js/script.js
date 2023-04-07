const sliderWrapper = document.querySelector('.slider-wrapper');
const sliderItems = document.querySelectorAll('.slide');
const sliderControls = document.querySelectorAll('.slider-control');

let slideWidth = sliderItems[0].clientWidth;
let slidePosition = 0;

// écouteur d'événement sur le bouton précédent
sliderControls[0].addEventListener('click', () => {
  slidePosition += slideWidth;
  if (slidePosition >= 0) {
    slidePosition = -(sliderItems.length - 1) * slideWidth;
  }
  sliderWrapper.style.transform = `translateX(${slidePosition}px)`;
});

// écouteur d'événement sur le bouton suivant
sliderControls[1].addEventListener('click', () => {
  slidePosition -= slideWidth;
  if (slidePosition <= -(sliderItems.length - 1) * slideWidth) {
    slidePosition = 0;
  }
  sliderWrapper.style.transform = `translateX(${slidePosition}px)`;
});
