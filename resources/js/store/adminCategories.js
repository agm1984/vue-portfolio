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
                const errorMsg = error?.response?.data?.message || error?.message || JSON.stringify(error);
                throw new Error(`adminCategories/getCategories# Problem fetching admin categories: ${errorMsg}`);
            } finally {
                this.isFetchingCategories = false;
            }
        },
    },
});
