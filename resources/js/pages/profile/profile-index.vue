<template>
    <div>
        <a-card class="p-32 w-512">
            <a-heading level="1" class="mb-32">
                Settings
            </a-heading>

            <div class="flex items-center justify-center pb-16">
                <router-link
                    v-for="link in links"
                    :key="`link-${link.name}`"
                    :to="{ name: link.to }"
                    tag="a"
                    class="px-16 py-8 font-bold rounded-sm"
                    active-class="text-white bg-primary border-1 border-primary"
                >
                    {{ link.name }}
                </router-link>
            </div>

            <div class="col-md-9">
                <transition name="fade" mode="out-in">
                    <router-view></router-view>
                </transition>
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
