import { bootstrap } from '@tabler/core/dist/js/tabler.esm.js';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-autofade]').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
        }, 2000);
    });
});
