<template>
    <Tag
        v-if="status"
        :value="status"
        rounded
    />
</template>

<script>
import Tag from 'primevue/tag';

export default {
    name: 'a-status-tag',

    components: {
        Tag,
    },

    props: {
        /**
         * Accepts a model's `status_nice` attribute (ie: string status not integerw)
         */
        status: {
            type: String,
            required: true,
        },
    },

    data() {
        return {};
    },

    computed: {
        type() {
            if (this.status === 'Active') return 'is-success is-light';
            if (this.status === 'Inactive') return 'is-warning is-light';
            throw new Error(`a-status-tag# Problem generating type, invalid status: '${this.status}'.`);
        },
    },

    methods: {},

};
</script>
