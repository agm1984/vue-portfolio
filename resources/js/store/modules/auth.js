import axios from 'axios';
import Cookies from 'js-cookie';

// types
export const REGISTER = 'REGISTER';
export const LOGIN = 'LOGIN';
export const SAVE_TOKEN = 'SAVE_TOKEN';
export const FETCH_USER = 'FETCH_USER';
export const FETCH_USER_SUCCESS = 'FETCH_USER_SUCCESS';
export const FETCH_USER_FAILURE = 'FETCH_USER_FAILURE';
export const UPDATE_USER = 'UPDATE_USER';
export const LOGOUT = 'LOGOUT';

// getters
export const getters = {
    user(state) {
        return state.user;
    },

    token(state) {
        return state.token;
    },

    check(state) {
        return (state.user !== null);
    },
};

// mutations
export const mutations = {
    [SAVE_TOKEN]: (state, { token, remember }) => {
        state.token = token;
        return Cookies.set('token', token, { expires: remember ? 365 : null });
    },

    [FETCH_USER_SUCCESS]: (state, { user }) => {
        state.user = user;
    },

    [FETCH_USER_FAILURE]: (state) => {
        state.user = null;
        state.token = null;
        return Cookies.remove('token');
    },

    [UPDATE_USER]: (state, { user }) => {
        state.user = user;
    },

    [LOGOUT]: (state) => {
        state.user = null;
        state.token = null;
        return Cookies.remove('token');
    },
};

// actions
export const actions = {
    async register({ commit }, payload) {
        try {
            const { data } = await axios.post(route('register'), payload);

            commit(FETCH_USER_SUCCESS, { user: data.user });

            return commit(SAVE_TOKEN, { token: data.token, remember: data.remember });
        } catch (err) {
            commit(LOGOUT);
            throw new Error(`auth/register# Problem registering new user: ${err}.`);
        }
    },

    saveToken({ commit }, payload) {
        return commit(SAVE_TOKEN, payload);
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get(route('me'));

            return commit(FETCH_USER_SUCCESS, { user: data });
        } catch (e) {
            return commit(FETCH_USER_FAILURE);
        }
    },

    updateUser({ commit }, payload) {
        return commit(UPDATE_USER, payload);
    },

    async login({ commit }, payload) {
        try {
            const { data } = await axios.post(route('login'), payload);

            commit(FETCH_USER_SUCCESS, { user: data.user });

            return commit(SAVE_TOKEN, { token: data.token, remember: data.remember });
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
};

// state
export const state = {
    user: null,
    token: Cookies.get('token'),
};
