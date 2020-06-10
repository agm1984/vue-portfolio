import axios from 'axios';
import Cookies from 'js-cookie';
import Swal from 'sweetalert2';
import store from '~/store';
import router from '~/router';

/**
 * Request interceptor: for each request to the server,
 * attach the CSRF token if it exists.
 *
 */
axios.interceptors.request.use(async (request) => {
    try {
        const csrf = Cookies.get('XSRF-TOKEN');

        request.withCredentials = true;

        if (csrf) {
            request.headers.common['XSRF-TOKEN'] = csrf;
        }

        return request;
    } catch (err) {
        throw new Error(`axios# Problem with request during pre-flight phase: ${err}.`);
    }
});

/**
 * Response interceptor: for each server error response,
 * check if client-side action is needed.
 *
 */
axios.interceptors.response.use(response => response, (error) => {
    if (!error.config) {
        return Promise.reject(error);
    }
    const { config, data, status } = error.response;

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

    if (status === 419) {
        if (config.url.name === 'logout') {
            console.log('running this 1');
            // if the user tries to log out with a stale-expired session, go to login page
            return Promise.resolve(router.push({ name: 'login' }).catch(() => {}));
        }

        // @TODO: needs more testing
        Swal.fire({
            icon: 'error',
            title: 'Page expired',
            text: 'Refresh the page and try again.',
            confirmButtonText: 'Ok',
        });
    }

    // if ((status === 401) && (data.error === 'token_expired_and_refreshed')) {
    //     store.commit('auth/LOGIN');
    //     error.config.headers.Authorization = `Bearer: ${store.getters['auth/token']}`;

    //     return axios.request(config); // re-try the request
    // }

    // if ((status === 401) && (data.error === 'token_expired')) {
    //     store.commit('auth/LOGOUT');

    //     if (router.currentRoute.name !== 'login') {
    //         router.push({ name: 'login' }).catch(() => {});
    //     }
    // }

    if ((status === 401) && (data.message === 'UNAUTHENTICATED')) {
        if (config.url.name === 'logout') {
            console.log('running this 2');
            // if the user tries to log out with a stale-expired session, go to login page
            return Promise.resolve(router.push({ name: 'login' }).catch(() => {}));
        }

        if (config.url.name === 'me') {
            // if fetching user details fails, do nothing
            return Promise.resolve();
        }

        console.log('definitely ran this:::');
        store.commit('auth/LOGOUT');

        if (router.currentRoute.name !== 'login') {
            return Promise.resolve(router.push({ name: 'login' }).catch(() => {}));
        }
    }

    if ((status === 400) && (data.message === 'Already authenticated.')) {
        // if the user somehow logs in again, do nothing
        Promise.resolve();
    }

    return Promise.reject(error);
});
