document.addEventListener('DOMContentLoaded', () => {
    // Toggle navigation menu for mobile view
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });

    // Smooth scrolling for anchor links
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 60, // Offset for fixed header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Handle resizing events for responsive design adjustments
    window.addEventListener('resize', () => {
        // Example: Adjust layout or other elements on resize if necessary
        // This is where you could add logic for dynamic layout changes
        console.log('Window resized. Implement any needed responsive adjustments.');
    });
});

