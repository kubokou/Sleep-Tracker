import './bootstrap';
import './calendar';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import axios from 'axios';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


Alpine.start();