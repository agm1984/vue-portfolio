<template>
    <div
        :class="[containerStyles, {
            'bg-grey-400': !hasImage
        }]"
    >
        <img
            v-if="hasImage"
            class="bg-no-repeat bg-cover rounded-full"
            :src="user.avatar_url"
        >

        <!-- <b-icon
            v-else
            pack="fas"
            icon="user"
            size="is-small"
        ></b-icon> -->
        <div v-else class="mt-2 font-aroly">
            {{ firstLetterOfName }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'a-avatar',

    props: {
        size: {
            type: Number,
            required: false,
            default: () => 32,
        },

        user: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {};
    },

    computed: {
        hasImage() {
            return (this.user.avatar_url && (this.user.avatar_url.length > 0));
        },

        firstLetterOfName() {
            return (this.user.name && this.user.name.charAt(0));
        },

        containerStyles() {
            const styles = ['flex items-center justify-center rounded-full border-1 border-primary'];

            if (this.size) styles.push(`w-${this.size} h-${this.size}`);
            else styles.push('w-32 h-32');

            return styles;
        },
    },

    created() {
        console.log('user', this.user);
    },

    watch: {
        user() {
            console.log('user changed!', this.user);
        },
    },

    methods: {},

};
</script>
