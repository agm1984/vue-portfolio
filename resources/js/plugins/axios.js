import axios from 'axios';

const logRequest = (config) => {
    console.log(config.method.toUpperCase(), config.url);
    return config;
};

const createApiClient = ({ router, toast }) => {
    const client = axios.create({
        withCredentials: true,
        xsrfCookieName: 'XSRF-TOKEN',
        xsrfHeaderName: 'X-XSRF-TOKEN',
    });

    const handleAuthError = async (status, config) => {
        const isLogout = config.url.endsWith('/logout');
        const isLoginRoute = router.currentRoute.value.name === 'login';

        if (isLogout) {
            await router.push({ name: 'login' }).catch(() => {});
            return { data: null, status: 200 };
        }

        const IGNORED_URLS = ['/api/user', '/sanctum/csrf-cookie'];

        if (IGNORED_URLS.some(path => config.url.endsWith(path))) {
            return { data: null, status: 401 };
        }

        if (!isLoginRoute) {
            toast.add({
                severity: 'error',
                summary: 'Session Expired',
                detail: 'Please sign in again.',
                life: 5000,
            });
            await router.push({ name: 'login' }).catch(() => {});
        }

        return Promise.reject(new Error('Unauthenticated'));
    };

    const ERROR_STRATEGIES = {
        429: () => {
            toast.add({
                severity: 'warn',
                summary: 'Too Many Requests',
                detail: 'Slow down... You\'ve been throttled.',
                life: 5000,
            });
        },
        419: (config) => handleAuthError(419, config),
        401: (config) => handleAuthError(401, config),
        500: () => {
            toast.add({
                severity: 'error',
                summary: 'Server Error',
                detail: 'Oops... Something went wrong! Please try again.',
                life: 5000,
            });
        },
    };

    const handleResponseError = async (error) => {
        if (!error.response) return Promise.reject(error);

        const { status, config } = error.response;
        const strategy = ERROR_STRATEGIES[status];

        if (strategy) {
            const result = await strategy(config);

            if (result) {
                return result;
            }
        }

        return Promise.reject(error);
    };

    client.interceptors.request.use(
        (config) => logRequest(config),
        (error) => Promise.reject(error),
    );

    client.interceptors.response.use(
        (response) => response,
        (error) => handleResponseError(error),
    );

    return client;
};

export default createApiClient;
