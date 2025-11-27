import { defineStore } from 'pinia';
import axios from 'axios';

export const useAdminUsersStore = defineStore('adminUsers', {
    state: () => ({
        isFetchingUsers: false,
        allUsers: [],
        isError: false,
    }),

    getters: {},

    actions: {
        async getAllUsers() {
            try {
                this.isFetchingUsers = true;

                const { data } = await axios.get(route('admin.users.list'));

                this.allUsers = data.users;
                this.isError = false;
            } catch (error) {
                this.isError = true;
                throw new Error(`adminUsers/getUsers# Problem fetching admin users: ${error}.`);
            } finally {
                this.isFetchingUsers = false;
            }
        },
    },
});
