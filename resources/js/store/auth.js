import { defineStore } from 'pinia';
import axios from 'axios';

const IS_LOGGED_IN = 'IS_LOGGED_IN';
const IS_LOGGED_OUT = 'IS_LOGGED_OUT';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    fsm: IS_LOGGED_OUT, // previously: state.state
    user: {},
    intendedUrl: '',
  }),

  getters: {
    // was: getters.check
    check: (state) => state.fsm === IS_LOGGED_IN,
    // alias if you prefer
    isLoggedIn() {
      return this.check;
    },
    // Vuex had a getter named 'intendedUrl' with special casing.
    // In Pinia we can’t use the same name as a state key, so:
    sanitizedIntendedUrl: (state) =>
      state.intendedUrl.length === 1 ? '' : state.intendedUrl,
  },

  actions: {
    // --- internal helpers (replace Vuex mutations) ---
    _login() {
      this.fsm = IS_LOGGED_IN
    },
    _logout() {
      this.fsm = IS_LOGGED_OUT
      this.user = {}
    },
    _setUser(user) {
      this.user = user
      this.fsm = IS_LOGGED_IN
    },
    _setIntendedUrl(url) {
      this.intendedUrl = url ?? ''
    },
    _clearIntendedUrl() {
      this.intendedUrl = ''
    },

    // --- actions (1:1 with your Vuex actions) ---
    async register(payload) {
      try {
        await axios.get('/sanctum/csrf-cookie');
        const { data } = await axios.post(route('register'), payload);
        this._setUser(data.user);
        this._login();
      } catch (err) {
        this._logout();
        throw new Error(`auth/register# Problem registering new user: ${err}.`);
      }
    },

    async fetchUser() {
      try {
        const { data } = await axios.get(route('me'));
        this._setUser(data);
      } catch {
        this._logout();
      }
    },

    updateUser(payload) {
      // accepts { user } like before, or the user object directly
      const user = payload?.user ?? payload;
      this._setUser(user);
    },

    async login(payload) {
      try {
        await axios.get('/sanctum/csrf-cookie')
        const { data } = await axios.post(route('login'), {
          ...payload,
          remember: payload.remember || undefined,
        });
        this._setUser(data.user);
        this._login();
        this._clearIntendedUrl();
      } catch (err) {
        this._logout();
        throw new Error(`auth/login# Problem logging user in: ${err}.`);
      }
    },

    async logout() {
      try {
        await axios.post(route('logout'));
        this._logout();
      } catch (err) {
        this._logout();
        throw new Error(`auth/logout# Problem logging user out: ${err}.`);
      }
    },

    async fetchOauthUrl({ provider }) {
      try {
        const { data } = await axios.post(route('oauth.redirect', provider));
        return data.url;
      } catch (err) {
        throw new Error(
          `auth/fetchOauthUrl# Problem redirecting to OAuth provider '${provider}': ${err}.`
        );
      }
    },

    setIntendedUrl(url) {
      this._setIntendedUrl(url);
    },

    clearIntendedUrl() {
      this._clearIntendedUrl();
    },
  },
});
