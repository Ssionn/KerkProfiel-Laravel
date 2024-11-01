import './bootstrap';
import Alpine from 'alpinejs';
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';

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
