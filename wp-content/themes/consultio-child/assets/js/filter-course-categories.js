document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.querySelector('.courses-filter-form');
    const hiddenCatInput = document.getElementById('course_cat_hidden');
    const checkboxes = document.querySelectorAll('.course-cat-checkbox');
    const categoryToggles = document.querySelectorAll('.cat-toggle');

    function updateHiddenCategories() {
        const selectedCategories = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        hiddenCatInput.value = selectedCategories.join(',');
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateHiddenCategories);
    });

    // Initialize the hidden input on page load
    updateHiddenCategories();

    categoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const parentItemWrap = this.closest('.cat-item-wrap');
            const childrenContainer = parentItemWrap.querySelector('.cat-children');
            if (childrenContainer) {
                childrenContainer.classList.toggle('expanded');
                this.textContent = childrenContainer.classList.contains('expanded') ? '-' : '+';
            }
        });
    });

    // Expand categories that contain selected children on load
    document.querySelectorAll('.cat-children.expanded').forEach(function(el) {
        const toggle = el.closest('.cat-item-wrap').querySelector('.cat-toggle');
        if (toggle) {
            toggle.textContent = '-';
        }
    });
});
