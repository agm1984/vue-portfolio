import axios from 'axios';
import Cookies from 'js-cookie';

// types
export const LOGOUT = 'LOGOUT';
export const SAVE_TOKEN = 'SAVE_TOKEN';
export const FETCH_USER = 'FETCH_USER';
export const FETCH_USER_SUCCESS = 'FETCH_USER_SUCCESS';
export const FETCH_USER_FAILURE = 'FETCH_USER_FAILURE';
export const UPDATE_USER = 'UPDATE_USER';

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
        Cookies.set('token', token, { expires: remember ? 365 : null });
    },

    [FETCH_USER_SUCCESS]: (state, { user }) => {
        state.user = user;
    },

    [FETCH_USER_FAILURE]: (state) => {
        state.user = null;
        state.token = null;
        Cookies.remove('token');
    },

    [LOGOUT]: (state) => {
        state.user = null;
        state.token = null;
        Cookies.remove('token');
    },

    [UPDATE_USER]: (state, { user }) => {
        state.user = user;
    },
};

// actions
export const actions = {
    saveToken({ commit, dispatch }, payload) {
        commit(SAVE_TOKEN, payload);
    },

    async fetchUser({ commit }) {
        try {
            const { data } = await axios.get(route('me'));

            commit(FETCH_USER_SUCCESS, { user: data });
        } catch (e) {
            commit(FETCH_USER_FAILURE);
        }
    },

    updateUser({ commit }, payload) {
        commit(UPDATE_USER, payload);
    },

    async logout({ commit }) {
        try {
            await axios.post(route('logout'));
        } catch (err) {
            throw new Error(`auth/logout# Problem logging out: ${err}.`);
        }

        commit(LOGOUT);
    },

    async fetchOauthUrl(ctx, { provider }) {
        try {
            const { data } = await axios.post(route('oauth.redirect', provider));

            return data.url;
        } catch (err) {
            throw new Error(`auth/fetchOauthUrl# Problem redirecting to provider '${provider}': ${err}.`);
        }
    },
};

// state
export const state = {
    user: null,
    token: Cookies.get('token'),
};
