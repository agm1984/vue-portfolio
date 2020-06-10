<template>
    <div>
        <div class="relative flex items-center justify-between">
            <a-heading level="1">
                {{ category.name }}
            </a-heading>

            <a-button v-if="isShowing" @click="toggleEdit">
                Edit
            </a-button>
        </div>

        <a-card v-if="isShowing">
            <a-show-field label="ID" :value="category.id"></a-show-field>

            <a-show-field label="Status" :value="category.status"></a-show-field>

            <a-show-field label="Slug" :value="category.slug"></a-show-field>

            <a-show-field label="Name" :value="category.name"></a-show-field>

            <a-show-field label="Created at" :value="category.created_at"></a-show-field>

            <a-show-field label="Updated at" :value="category.updated_at"></a-show-field>
        </a-card>

        <a-card v-if="isEditing" class="w-1/2">
            <edit-category
                :category="category"
                @reset="handleReset"
            ></edit-category>
        </a-card>

    </div>
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
            state: EDITING,
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
        return this.fetchData();
    },

    methods: {
        async fetchData() {
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
