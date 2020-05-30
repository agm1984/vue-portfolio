import axios from 'axios';
import Swal from 'sweetalert2';
import store from '~/store';
import router from '~/router';

/**
 * Decodes a JSON Web Token.
 *
 * @param {String} token
 * @return {Object}
 */
const parseJwt = (token) => {
    try {
        if (!token) {
            throw new Error('parseJwt# Token is required.');
        }

        const base64Payload = token.split('.')[1];
        let payload = new Uint8Array();

        try {
            payload = Buffer.from(base64Payload, 'base64');
        } catch (err) {
            throw new Error(`parseJwt# Malformed token: ${err}`);
        }

        return {
            decodedToken: JSON.parse(payload),
        };
    } catch (err) {
        console.log(`Bonus logging: ${err}`);

        return {
            error: 'Unable to decode token.',
        };
    }
};

/**
 * Request interceptor: for each request to the server,
 * attach the auth token if it exists.
 *
 */
axios.interceptors.request.use(async (request) => {
    try {
        const token = store.getters['auth/token'];

        if (token) {
            request.headers.common.Authorization = `Bearer ${token}`;
        }

        // https://laravel.com/docs/7.x/broadcasting
        // request.headers['X-Socket-Id'] = Echo.socketId()

        return request;
    } catch (err) {
        throw new Error(`axios# Problem with request during pre-flight phase: ${err}`);
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

    if ((status === 401) && (data.error === 'token_expired_and_refreshed')) {
        store.commit('auth/SAVE_TOKEN', { token: data.refresh.token });
        error.config.headers.Authorization = `Bearer: ${store.getters['auth/token']}`;

        return axios.request(config); // re-try the request
    }

    if ((status === 401) && (data.error === 'token_expired')) {
        store.commit('auth/LOGOUT');

        if (router.currentRoute.name !== 'login') {
            router.push({ name: 'login' }).catch(() => {});
        }
    }

    return Promise.reject(error);
});
