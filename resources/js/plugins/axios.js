import axios from 'axios';
import Swal from 'sweetalert2';
import store from '~/store';
import router from '~/router';

/**
 * Request interceptor: for each request to the server,
 * attach the auth token if it exists.
 *
 */
axios.interceptors.request.use((request) => {
    const token = store.getters['auth/token'];

    if (token) {
        request.headers.common.Authorization = `Bearer ${token}`;
    }

    // https://laravel.com/docs/7.x/broadcasting
    // request.headers['X-Socket-Id'] = Echo.socketId()

    return request;
});

/**
 * Response interceptor: for each server error response,
 * check if client-side action is needed.
 *
 */
axios.interceptors.response.use(response => response, (error) => {
    const { status } = error.response;

    console.log('ERROR RESPONSE', error.response);

    if (status >= 500) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.',
            confirmButtonText: 'Ok',
        });
    }

    if (status === 429) {
        // @TODO: needs more testing
        Swal.fire({
            icon: 'error',
            title: 'Slow down...',
            text: 'You\'ve been throttled.',
            confirmButtonText: 'Ok',
        });
    }

    if (status === 401) {
        const dialog = store.getters['auth/check'] ? {
            icon: 'warning',
            title: 'Session expired!',
            text: 'Please log in again to continue',
            confirmButtonText: 'Ok',
        } : {
            icon: 'warning',
            title: 'Unauthenticated!',
            text: 'Please log in to continue',
            confirmButtonText: 'Ok',
        };

        Swal.fire(dialog).then(() => {
            const intendedUrl = `${window.location.pathname}${window.location.search}`;
            store.commit('auth/LOGOUT');
            return router.push({ name: 'login', query: { redirect: intendedUrl } });
        });
    }

    return Promise.reject(error);
});
