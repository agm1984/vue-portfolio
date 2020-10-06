<template>
    <a-card with-geometry>
        <div class="relative flex items-center justify-between">
            <a-heading level="1">
                {{ category.name }}
            </a-heading>

            <a-button v-if="isShowing" @click="toggleEdit">
                Edit
            </a-button>
        </div>

        <a-card v-if="isShowing">
            <a-input-row type="is-split" heading="ID">
                <span>{{ category.id }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Status">
                <span>{{ category.status }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Slug">
                <span>{{ category.slug }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Name">
                <span>{{ category.name }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Created at">
                <span>{{ category.created_at }}</span>
            </a-input-row>

            <a-input-row type="is-split" heading="Updated at">
                <span>{{ category.updated_at }}</span>
            </a-input-row>
        </a-card>

        <div v-if="isEditing" class="">
            <edit-category
                :category="category"
                @reset="handleReset"
            ></edit-category>
        </div>

    </a-card>
</template>

<script>
import axios from 'axios';
import EditCategory from './edit-category.vue';

const SHOWING = 'SHOWING';
const EDITING = 'EDITING';

export default {
    name: 'show-category',

    components: {
        EditCategory,
    },

    middleware: ['auth', 'role-admin'],

    data() {
        return {
            state: SHOWING,
            category: {},
        };
    },

    computed: {
        isShowing() {
            return (this.state === SHOWING);
        },

        isEditing() {
            return (this.state === EDITING);
        },
    },

    mounted() {
        return this.fetchCategory();
    },

    methods: {
        async fetchCategory() {
            try {
                const { data } = await axios.get(route('admin.categories.show', this.$route.params.category));

                console.log('category', data.category);

                this.category = data.category;
                // this.state = SHOWING;
            } catch (err) {
                throw new Error(`show-category# Problem fetching category: ${err}.`);
            }
        },

        handleReset() {
            this.state = SHOWING;
        },

        toggleEdit() {
            this.state = EDITING;
        },
    },

};
</script>
