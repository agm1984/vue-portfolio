import { defineStore } from 'pinia';
import { api } from '~/services/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        isInitialized: false,
        user: null,
    }),

    getters: {
        isAuthenticated() {
            return !!this.user;
        },

        isAdmin() {
            return this.user?.roles_list?.includes('admin');
        },

        isStandard() {
            return this.user?.roles_list?.includes('standard');
        },
    },

    actions: {
        setUser(user) {
            this.user = user;
        },

        async register(payload) {
            try {
                await api.get('/sanctum/csrf-cookie');
                const { data } = await api.post(route('register'), payload);

                this.setUser(data.user);
            } catch (err) {
                this.user = null;
                throw new Error(`auth/register# Problem registering new user: ${err}.`);
            }
        },

        async fetchUser() {
            try {
                const response = await api.get(route('me'));

                const { data, status } = response || {};

                if (status === 200 && data) {
                    this.setUser(data);
                } else {
                    this.user = null;
                }

            } catch (error) {
                this.user = null;
            } finally {
                this.isInitialized = true;
            }
        },

        updateUser(payload) {
            const user = payload?.user ?? payload;
            this.setUser(user);
        },

        async login(payload) {
            try {
                await api.get('/sanctum/csrf-cookie')
                const { data } = await api.post(route('login'), {
                  ...payload,
                  remember: payload.remember || undefined,
                });

                this.setUser(data.user);
                this.isInitialized = true;
            } catch (err) {
                this.user = null;
                throw new Error(`auth/login# Problem logging user in: ${err}.`);
            }
        },

        async logout() {
            try {
                await api.post(route('logout'));
            } catch (error) {
                console.error(error);
            } finally {
                this.user = null;
                this.isInitialized = false;
            }
        },

        async fetchOauthUrl({ provider }) {
            try {
                const { data } = await api.post(route('oauth.redirect', provider));

                return data.url;
            } catch (err) {
                throw new Error(
                    `auth/fetchOauthUrl# Problem redirecting to OAuth provider '${provider}': ${err}.`
                );
            }
        },

        async forgotPassword(payload) {
            try {
                await api.get('/sanctum/csrf-cookie');
                const response = await api.post(route('password.email'), payload);

                return response;
            } catch (err) {
                throw new Error(`auth/forgotPassword# Problem during forgot password: ${err}.`);
            }
        },

        async resetPassword(payload) {
            try {
                await api.get('/sanctum/csrf-cookie');
                const response = await api.post(route('password.reset'), payload);

                return response;
            } catch (err) {
                throw new Error(`auth/resetPassword# Problem during reset password: ${err}.`);
            }
        },

        async resendVerificationEmail(email) {
            try {
                await api.get('/sanctum/csrf-cookie');
                const { data } = await api.post(route('verification.resend'), {
                    email,
                });

                return data;
            } catch (err) {
                throw new Error(`auth/resendVerificationEmail# ${err}`);
            }
        },

        async verifyEmailFromLink(userId, search) {
            try {
                await api.get('/sanctum/csrf-cookie');
                const url = `/email/verify/${userId}${search}`;

                const { data } = await api.post(url);

                return data;
            } catch (err) {
                console.error('Error verifying email:', err);
                throw err;
            }
        },
    },
});
