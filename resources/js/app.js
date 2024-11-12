import './bootstrap';
import Alpine from 'alpinejs';
import 'filepond/dist/filepond.min.css';
import 'flowbite';
import { ToastNotification } from './toast';

window.Alpine = Alpine

Alpine.start()

window.Toast = new ToastNotification();

