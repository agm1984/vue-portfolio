import Router from 'vue-router';
// import store from '~/store/index';
import routes from './routes';
import auth from '~/middleware/auth';
import checkAuth from '~/middleware/check-auth';
import guest from '~/middleware/guest';
import roleAdmin from '~/middleware/role-admin';

// define middleware that runs on every page in the application
const globalMiddleware = ['check-auth'];

// define route middleware that can be used anywhere
const availableMiddleware = {
    auth,
    'check-auth': checkAuth,
    guest,
    'role-admin': roleAdmin,
};

/**
 * Resolve async components.
 *
 * @param {Array} components
 * @return {Array}
 */
function resolveComponents(components) {
    return Promise.all(components.map((component) => {
        if (typeof component === 'function') return component();
        return component;
    }));
}

/**
 * Creates and exports a new router instance.
 *
 * @return {Router}
 */
function createRouter() {
    const router = new Router({
        scrollBehavior, // eslint-disable-line no-use-before-define
        mode: 'history',
        routes,
    });

    router.beforeEach(beforeEach); // eslint-disable-line no-use-before-define
    router.afterEach(afterEach); // eslint-disable-line no-use-before-define

    return router;
}

const router = createRouter();

export default router;

/**
 * Scroll Behaviour
 *
 * @link https://router.vuejs.org/en/advanced/scroll-behavior.html
 *
 * @param {Route} to
 * @param {Route} from
 * @param {Object|undefined} savedPosition
 * @return {Object}
 */
function scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
        return savedPosition;
    }

    if (to.hash) {
        return { selector: to.hash };
    }

    const [component] = router.getMatchedComponents({ ...to }).slice(-1);

    if (component && component.scrollToTop === false) {
        return {}; // no scrolling will occur
    }

    return { x: 0, y: 0 };
}

/**
 * Merge the the global middleware with the components middleware.
 *
 * @param {Array} components
 * @return {Array}
 */
function getMiddleware(components) {
    const middleware = [...globalMiddleware];

    components.filter(c => c.middleware).forEach((component) => {
        if (Array.isArray(component.middleware)) {
            middleware.push(...component.middleware);
        } else {
            middleware.push(component.middleware);
        }
    });

    return middleware;
}

/**
 * Call each middleware.
 *
 * @param {Array} middleware
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 * @return {Function}
 */
function callMiddleware(middleware, to, from, next) {
    const stack = middleware.reverse();

    const _next = (...args) => { // eslint-disable-line no-underscore-dangle
        // stop if `_next` was called with an argument or the stack is empty
        if (args.length > 0 || stack.length === 0) {
            if (args.length > 0) {
                router.app.$loading.finish();
            }

            return next(...args);
        }

        const mw = stack.pop();

        if (typeof mw === 'function') {
            return mw(to, from, _next);
        }

        if (availableMiddleware[mw]) {
            return availableMiddleware[mw](to, from, _next);
        }

        throw Error(`callMiddleware# Undefined middleware: '${mw}'.`);
    };

    return _next();
}

/**
 * Before each route-change event hook.
 *
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 * @return {Function}
 */
async function beforeEach(to, from, next) {
    let components = [];

    try {
        // get all matched components for this route and resolve them
        components = await resolveComponents(router.getMatchedComponents({ ...to }));
    } catch (error) {
        // if any components are stale or broken, reloading the page should fix it
        if (/^Loading( CSS)? chunk (\d)+ failed\./.test(error.message)) {
            return window.location.reload(true);
        }
    }

    if (components.length === 0) {
        return next();
    }

    // start the loading bar
    if (components[components.length - 1].loading !== false) {
        router.app.$nextTick(() => router.app.$loading.start());
    }

    // get the middleware for all matched components
    const middleware = getMiddleware(components);

    // call each middleware
    return callMiddleware(middleware, to, from, (...args) => {
        // set the application layout only if `next()` was called with no args
        if (args.length === 0) {
            router.app.setLayout(components[0].layout || '');
        }

        return next(...args);
    });
}

/**
 * After each route-change event hook.
 *
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 * @return {Function}
 */
async function afterEach(to, from, next) { // eslint-disable-line no-unused-vars
    await router.app.$nextTick();
    return router.app.$loading.finish();
}
