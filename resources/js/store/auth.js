import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isAuthenticated: false,
        user: {},
    }),

    getters: {},

    actions: {
        setUser(user) {
            this.user = user;
            this.isAuthenticated = true;
        },

        async register(payload) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const { data } = await axios.post(route('register'), payload);

                this.setUser(data.user);
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
                this.user = {};
                throw new Error(`auth/register# Problem registering new user: ${err}.`);
            }
        },

        async fetchUser() {
            try {
                const { data } = await axios.get(route('me'));

                this.setUser(data);
                this.isAuthenticated = true;
            } catch {
                this.isAuthenticated = false;
                this.user = {};
            }
        },

        updateUser(payload) {
            // accepts { user } like before, or the user object directly
            const user = payload?.user ?? payload;
            this.setUser(user);
        },

        async login(payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                const { data } = await axios.post(route('login'), {
                  ...payload,
                  remember: payload.remember || undefined,
                });

                this.setUser(data.user);
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
                this.user = {};
                throw new Error(`auth/login# Problem logging user in: ${err}.`);
            }
        },

        async logout() {
            try {
                await axios.post(route('logout'));
            } catch (error) {
                console.error(error);
            } finally {
                this.isAuthenticated = false;
                this.user = {};
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

        async forgotPassword(payload) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const response = await axios.post(route('password.email'), payload);

                return response;
            } catch (err) {
                throw new Error(`auth/forgotPassword# Problem during forgot password: ${err}.`);
            }
        },

        async resetPassword(payload) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const response = await axios.post(route('password.reset'), payload);

                return response;
            } catch (err) {
                throw new Error(`auth/resetPassword# Problem during reset password: ${err}.`);
            }
        },

        async resendVerificationEmail(email) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const { data } = await axios.post(route('verification.resend'), {
                    email,
                });

                return data;
            } catch (err) {
                throw new Error(`auth/resendVerificationEmail# ${err}`);
            }
        },

        async verifyEmailFromLink(userId, search) {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const url = `/email/verify/${userId}${search}`;

                const { data } = await axios.post(url);

                return data;
            } catch (err) {
                console.error('Error verifying email:', err);
                throw err;
            }
        },
    },
});
