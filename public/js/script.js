const sliderWrapper = document.querySelector('.slider-wrapper');
const slides = document.querySelectorAll('.slide');
const controls = document.querySelectorAll('.slider-controls button');
const dotsWrapper = document.createElement('div');
dotsWrapper.classList.add('slider-dots');

slides.forEach((slide, index) => {
  const dot = document.createElement('button');
  dot.classList.add('slider-dot');
  dotsWrapper.appendChild(dot);

  dot.addEventListener('click', () => {
    sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
    setActiveDot(dot);
  });
});

function setActiveDot(dot) {
  document.querySelectorAll('.slider-dot').forEach(d => d.classList.remove('active'));
  dot.classList.add('active');
}

document.querySelector('.slider').appendChild(dotsWrapper);
setActiveDot(document.querySelector('.slider-dot'));
