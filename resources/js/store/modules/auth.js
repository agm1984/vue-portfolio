import axios from 'axios';

/**
 * Users can login via email/password handled by `LoginController.php`,
 * or via OAuth GitHub and/or Twitter handled by `OAuthController.php`.
 *
 * Any Vue component can check if a user is currently authenticated by polling
 * the predicate function `this.$store.getters['auth/check']` which simply
 * checks if `this.$store.state.auth.state === IS_LOGGED_IN`.
 */

const IS_LOGGED_IN = 'IS_LOGGED_IN';
const IS_LOGGED_OUT = 'IS_LOGGED_OUT';

// types
export const LOGIN = 'LOGIN';
export const FETCH_USER = 'FETCH_USER';
export const FETCH_USER_SUCCESS = 'FETCH_USER_SUCCESS';
export const FETCH_USER_FAILED = 'FETCH_USER_FAILED';
export const UPDATE_USER = 'UPDATE_USER';
export const LOGOUT = 'LOGOUT';
export const SET_INTENDED_URL = 'SET_INTENDED_URL';
export const CLEAR_INTENDED_URL = 'CLEAR_INTENDED_URL';

// getters
export const getters = {
    check(state) {
        return (state.state === IS_LOGGED_IN);
    },

    user(state) {
        return state.user;
    },

    intendedUrl(state) {
        if (state.intendedUrl.length === 1) return ''; // ignore redirect to '/' to keep URL pretty
        return state.intendedUrl;
    },
};

// mutations
export const mutations = {
    [LOGIN]: (state) => {
        state.state = IS_LOGGED_IN;
    },

    [FETCH_USER_SUCCESS]: (state, { user }) => {
        state.user = user;
        state.state = IS_LOGGED_IN;
    },

    [FETCH_USER_FAILED]: (state) => {
        state.state = IS_LOGGED_OUT;
        state.user = {};
    },

    [UPDATE_USER]: (state, { user }) => {
        state.user = user;
        state.state = IS_LOGGED_IN;
    },

    [LOGOUT]: (state) => {
        state.state = IS_LOGGED_OUT;
        state.user = {};
    },

    [SET_INTENDED_URL]: (state, intendedUrl) => {
        state.intendedUrl = intendedUrl;
    },

    [CLEAR_INTENDED_URL]: (state) => {
        state.intendedUrl = '';
    },
};

// actions
export const actions = {
    async register({ commit }, payload) {
        try {
            const { data } = await axios.post(route('register'), payload);

            commit(FETCH_USER_SUCCESS, { user: data.user });

            return commit(LOGIN);
        } catch (err) {
            commit(LOGOUT);
            throw new Error(`auth/register# Problem registering new user: ${err}.`);
        }
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get(route('me'));

            return commit(FETCH_USER_SUCCESS, { user: data });
        } catch (e) {
            return commit(FETCH_USER_FAILED);
        }
    },

    updateUser({ commit }, payload) {
        return commit(UPDATE_USER, payload);
    },

    async login({ commit }, payload) {
        try {
            const { data } = await axios.post(route('login'), {
                ...payload,
                remember: payload.remember || undefined,
            });

            commit(FETCH_USER_SUCCESS, { user: data.user });
            commit(LOGIN);

            return commit(CLEAR_INTENDED_URL);
        } catch (err) {
            commit(LOGOUT);
            throw new Error(`auth/login# Problem logging user in: ${err}.`);
        }
    },

    async logout({ commit }) {
        try {
            await axios.post(route('logout'));

            return commit(LOGOUT);
        } catch (err) {
            commit(LOGOUT);

            throw new Error(`auth/logout# Problem logging user out: ${err}.`);
        }
    },

    async fetchOauthUrl(ctx, { provider }) {
        try {
            const { data } = await axios.post(route('oauth.redirect', provider));

            return data.url;
        } catch (err) {
            throw new Error(`auth/fetchOauthUrl# Problem redirecting to OAuth provider '${provider}': ${err}.`);
        }
    },

    setIntendedUrl({ commit }, payload) {
        return commit(SET_INTENDED_URL, payload);
    },

    clearIntendedUrl({ commit }) {
        return commit(CLEAR_INTENDED_URL);
    },

};

// state
export const state = {
    state: IS_LOGGED_OUT,
    user: {},
    intendedUrl: '',
};
