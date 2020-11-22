<template>
    <div
        :class="['flex items-center justify-center w-32 h-32 rounded-full border-1 border-primary', {
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
    name: 'a-profile-image',

    props: {
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
            return (this.user.avatar_url.length > 0);
        },

        firstLetterOfName() {
            return (this.user.name.charAt(0));
        },
    },

    created() {
        console.log('user', this.user);
    },

    methods: {},

};
</script>
