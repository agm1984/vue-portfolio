import { defineStore } from 'pinia';
import axios from 'axios';

export const useAdminDashboardStore = defineStore('adminDashboard', {
    state: () => ({
        isFetchingMetrics: false,
        metrics: {},
        isError: false,
    }),

    getters: {},

    actions: {
        async getDashboardMetrics() {
            try {
                this.isFetchingMetrics = true;

                const { data } = await axios.get(route('admin.dashboard.metrics'));
                this.metrics = data;
                this.isError = false;
            } catch (error) {
                this.isError = true;
                throw new Error(`adminDashboard/getDashboardMetrics# Problem fetching dashboard metrics: ${error}.`);
            } finally {
                this.isFetchingMetrics = false;
            }
        },
    },
});
