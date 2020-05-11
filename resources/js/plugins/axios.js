import axios from 'axios';
import Swal from 'sweetalert2';
import store from '~/store';
import router from '~/router';

// Request interceptor
axios.interceptors.request.use((request) => {
    const token = store.getters['auth/token'];
    if (token) {
        request.headers.common.Authorization = `Bearer ${token}`;
    }

    // https://laravel.com/docs/7.x/broadcasting
    // request.headers['X-Socket-Id'] = Echo.socketId()

    return request;
});

// Response interceptor
axios.interceptors.response.use(response => response, (error) => {
    const { status } = error.response;

    console.log('ERROR RESPONSE', error.response);

    if (status >= 500) {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.',
            reverseButtons: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
        });
    }

    if (status === 401 && store.getters['auth/check']) {
        Swal.fire({
            type: 'warning',
            title: 'Session expired!',
            text: 'Please log in again to continue',
            reverseButtons: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
        }).then(() => {
            store.commit('auth/LOGOUT');

            router.push({ name: 'login' });
        });
    }

    return Promise.reject(error);
});
