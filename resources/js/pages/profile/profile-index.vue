<template>
    <div>
        <a-card class="p-8 w-full">
            <h2 level="1" class="mb-32">
                Settings
            </h2>

            <div class="flex items-center justify-center pb-16">
                <router-link
                    v-for="link in links"
                    :key="`link-${link.name}`"
                    :to="{ name: link.to }"
                    tag="a"
                    class="px-16 py-8 font-bold rounded-sm"
                    active-class="bg-grey-900 border-1 border-primary"
                >
                    {{ link.name }}
                </router-link>
            </div>

            <div class="col-md-9">
                <router-view></router-view>
            </div>
        </a-card>
    </div>
</template>

<script>
export default {
    name: 'profile-index',

    middleware: 'auth',

    data() {
        return {};
    },

    computed: {
        links() {
            return [
                {
                    name: 'Profile',
                    to: 'settings.profile',
                },
                {
                    name: 'Password',
                    to: 'settings.password',
                },
            ];
        },
    },

    methods: {},

};
</script>
