// Add animation to sections when scrolled into view
const sections = document.querySelectorAll('.section-animate');

const animateSection = () => {
    sections.forEach((section) => {
        const sectionPosition = section.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (sectionPosition < windowHeight - 100) {
            section.classList.add('animate');
        } else {
            section.classList.remove('animate');
        }
    });
}

window.addEventListener('scroll', animateSection);
window.addEventListener('resize', animateSection);
