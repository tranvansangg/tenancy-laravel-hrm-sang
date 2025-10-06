document.addEventListener('DOMContentLoaded', function () {
    const collapseButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');

    collapseButtons.forEach(button => {
        const targetSelector = button.getAttribute('data-bs-target');
        const target = document.querySelector(targetSelector);

        if (target) {
            const bsCollapse = new bootstrap.Collapse(target, { toggle: false });

            button.addEventListener('click', function (e) {
                e.preventDefault();
                bsCollapse.toggle();
            });

            target.addEventListener('shown.bs.collapse', function () {
                button.textContent = 'Ẩn';
            });

            target.addEventListener('hidden.bs.collapse', function () {
                button.textContent = 'Xem';
            });
        }
    });
});
