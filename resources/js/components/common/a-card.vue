<template>
    <div class="relative h-auto p-32 a-card">
        <a-sacred-geometry :id="id"></a-sacred-geometry>

        <!-- card content -->
        <slot></slot>

    </div>
</template>

<script>
import generateUuid from '../utils/generateUniqueId';

export default {
    name: 'a-card',

    props: {
        id: {
            type: String,
            required: false,
            default: generateUuid,
        },
    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
