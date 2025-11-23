import { defineStore } from 'pinia';
import axios from 'axios';

export const usePublicExamplesStore = defineStore('publicExamples', {
    state: () => ({
        isFetchingExamples: false,
        isFetchingCategories: false,
        allExamples: [],
        allCategories: [],
        activeCategory: 'all',
        searchTerms: '',
    }),

    getters: {
        formattedFilters() {
            const filters = {};

            if (this.searchTerms) {
                filters.search = this.searchTerms;
            }

            filters.category = this.activeCategory;

            return filters;
        },

        filteredExamples() {
            let filtered = this.allExamples;

            if (this.searchTerms) {
                const isMatchFound = (example) => {
                    return example.name.toLowerCase().includes(this.searchTerms.toLowerCase())
                        || example.category.name.toLowerCase().includes(this.searchTerms.toLowerCase())
                        || example.summary.toLowerCase().includes(this.searchTerms.toLowerCase())
                        || example.conclusion.toLowerCase().includes(this.searchTerms.toLowerCase())
                        || example.slug.toLowerCase().includes(this.searchTerms.toLowerCase())
                        || example.tags.some(tag => tag.toLowerCase().includes(this.searchTerms.toLowerCase()));
                };

                filtered = filtered.filter(isMatchFound);
            }

            if (this.activeCategory === 'all') return filtered;

            filtered = filtered.filter(example => example.category.slug === this.activeCategory);

            return filtered;
        },
    },

    actions: {
        getUrlParams(query) {
            this.searchTerms = query.search || '';
            this.activeCategory = query.category || 'all';
        },

        async getAllExamples() {
            try {
                this.isFetchingExamples = true;

                const { data } = await axios.get(route('public.examples.list'));

                this.allExamples = data.examples;
            } catch (error) {
                throw new Error(`publicExamples/getExamples# Problem fetching public examples: ${error}.`);
            } finally {
                this.isFetchingExamples = false;
            }
        },

        async getAllCategories() {
            try {
                this.isFetchingCategories = true;

                const { data } = await axios.get(route('public.categories.list'));

                this.allCategories = data.categories;
            } catch (error) {
                throw new Error(`publicExamples/getAllCategories# Problem fetching public categories: ${error}.`);
            } finally {
                this.isFetchingCategories = false;
            }
        },
    },
});
