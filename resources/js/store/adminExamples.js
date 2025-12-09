import { defineStore } from 'pinia';
import { api } from '~/services/api';

export const useAdminExamplesStore = defineStore('adminExamples', {
    state: () => ({
        isFetchingExamples: false,
        allExamples: [],
        isError: false,
    }),

    getters: {},

    actions: {
        async getAllExamples() {
            try {
                this.isFetchingExamples = true;

                const { data } = await api.get(route('admin.examples.list'));
                this.allExamples = data.examples;
                this.isError = false;
            } catch (error) {
                this.isError = true;
                const errorMsg = error?.response?.data?.message || error?.message || JSON.stringify(error);
                throw new Error(`adminExamples/getExamples# Problem fetching admin examples: ${errorMsg}`);
            } finally {
                this.isFetchingExamples = false;
            }
        },
    },
});
