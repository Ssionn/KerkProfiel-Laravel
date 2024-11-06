import './bootstrap';
import Alpine from 'alpinejs';
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import 'flowbite';

window.Alpine = Alpine

Alpine.start()

const inputElement = document.querySelector('input[type="file"].filepond');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

FilePond.create(inputElement).setOptions({
    server: {
        process: './uploads/process',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    }
});

new Modal(document.getElementById('uitnodigen-modal'), {
    backdropClasses: 'bg-transparent'
});

class ToastNotification {
    constructor() {
        this.container = document.getElementById('toast-container');
    }

    show(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `
                    transform translate-x-full opacity-0 transition-all duration-300
                    flex items-center p-4 mb-4 rounded-lg shadow-lg
                    ${type === 'success' ? 'bg-green-500' : ''}
                    ${type === 'error' ? 'bg-red-500' : ''}
                    ${type === 'warning' ? 'bg-yellow-500' : ''}
                    ${type === 'info' ? 'bg-blue-500' : ''}
                    text-white
                `;

        let icon = '';
        switch (type) {
            case 'success':
                icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>`;
                break;
            case 'error':
                icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>`;
                break;
        }

        toast.innerHTML = `
                    ${icon}
                    <span class="text-sm font-medium">${message}</span>
                `;

        this.container.appendChild(toast);

        toast.offsetHeight;

        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                this.container.removeChild(toast);
            }, 300);
        }, duration);
    }
}
window.Toast = new ToastNotification();
