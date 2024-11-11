let slideIndex = 0;

function moveSlide(n) {
    const slides = document.querySelectorAll(".slide");
    const totalSlides = slides.length;

    slideIndex += n;

    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } else if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }

    const offset = -slideIndex * 100;
    document.querySelector(".slider-wrapper").style.transform = `translateX(${offset}%)`;
}

setInterval(() => {
    moveSlide(1);
}, 5000); // Slide changes every 3 seconds
