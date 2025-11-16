// import './bootstrap';

import Alpine from 'alpinejs';
import '../css/app.css';
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

window.Alpine = Alpine;

Alpine.start();
