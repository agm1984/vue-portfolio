window.axios = require('axios');

const token = document.head.querySelector('meta[name="csrf-token"]');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    throw new Error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
