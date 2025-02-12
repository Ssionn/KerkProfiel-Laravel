import Alpine from 'alpinejs';
import './bootstrap';
import './filepond';
import 'filepond/dist/filepond.min.css';
import 'flowbite';
import { ToastNotification } from './toast';

window.Toast = new ToastNotification();
window.Alpine = Alpine

Alpine.start()
