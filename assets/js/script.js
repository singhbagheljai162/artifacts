
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    let slideInterval;

    // Function to show a specific slide
    function showSlide(index) {
        // Handle wrap-around
        if (index >= slides.length) currentSlideIndex = 0;
        else if (index < 0) currentSlideIndex = slides.length - 1;
        else currentSlideIndex = index;

        // Remove active class from all slides and dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Add active class to current slide and dot
        slides[currentSlideIndex].classList.add('active');
        dots[currentSlideIndex].classList.add('active');
    }

    // Next/Prev Controls
    function changeSlide(direction) {
        showSlide(currentSlideIndex + direction);
        resetTimer(); // Reset auto-slide timer when manually clicked
    }

    // Dot Controls
    function currentSlide(index) {
        showSlide(index);
        resetTimer();
    }

    // Event Listeners for arrows
    document.querySelector('.next-btn').addEventListener('click', () => changeSlide(1));
    document.querySelector('.prev-btn').addEventListener('click', () => changeSlide(-1));

    // Auto Slide functionality (changes every 6 seconds)
    function startTimer() {
        slideInterval = setInterval(() => {
            changeSlide(1);
        }, 6000); 
    }

    // Resets timer so auto-slide doesn't trigger immediately after a manual click
    function resetTimer() {
        clearInterval(slideInterval);
        startTimer();
    }

    // Initialize auto slider
    startTimer();
