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
            reverseButtons: true,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
        });
    }

    if (status === 401 && store.getters['auth/check']) {
        console.log('error 401 server session expired but client session exists');
        Swal.fire({
            icon: 'warning',
            title: 'Session expired!',
            text: 'Please log in again to continue',
            confirmButtonText: 'Ok',
        }).then(() => {
            const intended = window.location.pathname;

            store.commit('auth/LOGOUT');

            router.push({ name: 'login', query: { redirect: intended } });
        });
    }

    if (status === 401 && !store.getters['auth/check']) {
        console.log('error 401 server session expired and no client session');
        Swal.fire({
            icon: 'warning',
            title: 'Unauthenticated!',
            text: 'Please log in to continue',
            confirmButtonText: 'Ok',
        }).then(() => {
            const intended = window.location.pathname;

            store.commit('auth/LOGOUT');

            router.push({ name: 'login', query: { redirect: intended } });
        });
    }

    return Promise.reject(error);
});
