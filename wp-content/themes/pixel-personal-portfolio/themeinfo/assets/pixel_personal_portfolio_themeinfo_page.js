document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.accordion-item');

    faqItems.forEach(item => {
        const button = item.querySelector('.accordion-button');
        const collapse = item.querySelector('.accordion-collapse');

        button.addEventListener('click', () => {
            const isOpen = button.classList.contains('active');
            
            // Close all open items
            faqItems.forEach(otherItem => {
                const otherButton = otherItem.querySelector('.accordion-button');
                const otherCollapse = otherItem.querySelector('.accordion-collapse');
                otherButton.classList.remove('active');
                otherCollapse.classList.remove('show');
            });

            // Toggle the current item
            if (!isOpen) {
                button.classList.add('active');
                collapse.classList.add('show');
            }
        });
    });
});