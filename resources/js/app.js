// import './bootstrap';

import Alpine from 'alpinejs';
import '../css/app.css';
import { createIcons, icons } from 'lucide';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

window.notyf = new Notyf({
    duration: 3200,
    position: { x: 'center', y: 'top' },
    dismissible: false,
    ripple: false,
    types: [
        {
            type: 'success',
            background: 'rgba(34, 197, 94, 0.12)',
            icon: {
                className: 'fas fa-check-circle',
                tagName: 'i',
                color: '#22c55e'
            }
        },
        {
            type: 'info',
            background: 'rgba(59, 130, 246, 0.12)',
            icon: {
                className: 'fas fa-info-circle',
                tagName: 'i',
                color: '#3b82f6'
            }
        },
        {
            type: 'warning',
            background: '#f59e0b',
            icon: {
                className: 'fas fa-exclamation-triangle',
                tagName: 'i',
                color: 'orange'
            }
        }
    ]
});

// ERROR (tengah atas)
window.notyfError = new Notyf({
    duration: 3500,
    position: { x: 'center', y: 'top' },
    dismissible: false,
    ripple: false,
    types: [
        {
            type: 'error',
            background: 'rgba(239, 68, 68, 0.12)',
            icon: {
                className: 'fas fa-times-circle',
                tagName: 'i',
                color: '#ef4444'
            }
        },
    ]
});

// STATUS (PROFILE INFORMATION)
window.notyfStatus = new Notyf({
    duration: 3200,
    position: { x: 'center', y: 'top' },
    dismissible: false,
    ripple: false,
    types: [
        {
            type: 'status',
            background: 'rgba(139, 92, 246, 0.12)',
            icon: {
                className: 'fas fa-sync-alt',
                tagName: 'i',
                color: '#8b5cf6'
            }
        }
    ]
});

// PASSWORD UPDATED
window.notyfProfile = new Notyf({
    duration: 3200,
    position: { x: 'center', y: 'top' },
    dismissible: false,
    ripple: false,
    types: [
        {
            type: 'password',
            background: 'rgba(99, 102, 241, 0.12)',
            icon: {
                className: 'fas fa-shield-alt',
                tagName: 'i',
                color: '#6366f1'
            }
        },

        {
            type: 'profile_information',
            background: 'rgba(139, 92, 246, 0.12)',
            icon: {
                className: 'fas fa-user-check',
                tagName: 'i',
                color: '#8b5cf6'
            }
        }
    ]
});

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

window.createIcons = createIcons;
window.lucideIcons = icons;

window.Alpine = Alpine;

Alpine.start();
