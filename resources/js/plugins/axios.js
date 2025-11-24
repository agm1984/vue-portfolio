import axios from 'axios';
import router from '~/router';
import { useToast } from '~/composables/useToast';

axios.defaults.withCredentials = true;          // send cookies
axios.defaults.xsrfCookieName = 'XSRF-TOKEN';   // Laravel's cookie
axios.defaults.xsrfHeaderName = 'X-XSRF-TOKEN'; // header Laravel expects

/**
 * Response interceptor: for each server error response,
 * check if client-side action is needed.
 */
axios.interceptors.response.use(response => response, (error) => {
    const toast = useToast();

    if (!error.config) {
        return Promise.reject(error);
    }

    const { config, data, status } = error.response;

    // for debugging:
    console.log('ERROR RESPONSE', error.response);
    toast.add({ severity: 'error', summary: `Error ${status}`, detail: data.message || 'An error occurred.', life: 5000 });

    if (status >= 500) {
        toast.add({ severity: 'error', summary: 'Server Error', detail: 'Oops... Something went wrong! Please try again.', life: 5000 });
    }

    if (status === 429) {
        // @TODO: needs more testing
        toast.add({ severity: 'warn', summary: 'Too Many Requests', detail: 'Slow down... You\'ve been throttled.', life: 5000 });
    }

    if (status === 422) {
        // @TODO: needs more testing
        // load error display with field names mapped to errors
    }

    if (status === 419) {
        if (config.url.name === 'logout') {
            console.log('axios## running this 1');
            // if the user tries to log out with a stale-expired session, go to login page
            return Promise.resolve(router.push({ name: 'login' }).catch(() => {}));
        }

        // @TODO: needs more testing
        toast.add({ severity: 'error', summary: 'Page Expired', detail: 'Refresh the page and try again.', life: 5000 });
    }

    if ((status === 401) && (data.message === 'UNAUTHENTICATED')) {
        if (config.url.name === 'logout') {
            // if the user tries to log out with a stale-expired session, go to login page
            return Promise.resolve(router.push({ name: 'login' }).catch(() => {}));
        }

        if (config.url.name === 'me') {
            // if fetching user details fails, do nothing
            return Promise.resolve();
        }

        // store.commit('auth/LOGOUT');

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
