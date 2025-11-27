import { defineStore } from 'pinia';
import axios from 'axios';

export const useAdminCategoriesStore = defineStore('adminCategories', {
    state: () => ({
        isFetchingCategories: false,
        allCategories: [],
        isError: false,
    }),

    getters: {},

    actions: {
        async getAllCategories() {
            try {
                this.isFetchingCategories = true;

                const { data } = await axios.get(route('admin.categories.list'));

                this.allCategories = data.categories;
                this.isError = false;
            } catch (error) {
                this.isError = true;
                throw new Error(`adminCategories/getCategories# Problem fetching admin categories: ${error}.`);
            } finally {
                this.isFetchingCategories = false;
            }
        },
    },
});
