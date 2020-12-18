import axios from 'axios';

// types
export const SAVE_USER = 'SAVE_USER';
export const FETCH_USER = 'FETCH_USER';
export const UPDATE_USER = 'UPDATE_USER';
export const DELETE_USER = 'DELETE_USER';
export const FETCH_ALL_USERS = 'FETCH_ALL_USERS';

// getters
export const getters = {};

// mutations
export const mutations = {};

// actions
export const actions = {};

// state
export const state = {};

const users = {
    namespaced: true,
    getters,
    mutations,
    actions,
    state,
};

export default users;
