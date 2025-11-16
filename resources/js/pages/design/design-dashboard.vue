<template>
    <div class="flex-1 w-full max-w-5xl mx-auto flex p-8">
        <div class="min-w-[125px] max-w-[125px] flex flex-col gap-4">
            <h1>Design System</h1>

            <router-link
                :to="{ name: 'design' }"
                :class="['w-full inline-flex items-center font-semibold', {
                    'border-r-2 border-gray-900': isDashboard,
                }]"
                active-class=""
            >Dashboard</router-link>

            <router-link
                :to="{ name: 'design.buttons' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Buttons</router-link>

            <router-link
                :to="{ name: 'design.colours' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Colours</router-link>

            <router-link
                :to="{ name: 'design.sizing' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Space & Size</router-link>

            <router-link
                :to="{ name: 'design.typography' }"
                class="w-full inline-flex items-center font-semibold"
                active-class="border-r-2 border-gray-900"
            >Typography</router-link>
        </div>

        <div class="w-full h-auto ml-8">
            <template v-if="isDashboard">
                <router-link :to="{ name: 'design.buttons' }">
                    <a-card class="flex flex-wrap p-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full border">
                            <i class="pi pi-window-minimize text-gray-500" style="font-size: 24px;"></i>
                        </div>
                        <div class="flex items-center ml-4">
                            <h3>Buttons</h3>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.colours' }">
                    <a-card class="flex flex-wrap p-4 mt-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full border">
                            <i class="pi pi-palette text-gray-500" style="font-size: 24px;"></i>
                        </div>
                        <div class="flex items-center ml-4">
                            <h3>Colours</h3>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.sizing' }">
                    <a-card class="flex flex-wrap p-4 mt-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full border">
                            <i class="pi pi-external-link text-gray-500" style="font-size: 24px;"></i>
                        </div>
                        <div class="flex items-center ml-4">
                            <h3>Space & Size</h3>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.typography' }">
                    <a-card class="flex flex-wrap p-4 mt-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full border">
                            <i class="pi pi-align-left text-gray-500" style="font-size: 24px;"></i>
                        </div>
                        <div class="flex items-center ml-4">
                            <h3>Typography</h3>
                        </div>
                    </a-card>
                </router-link>
            </template>

            <router-view v-else></router-view>
        </div>

    </div>
</template>

<script>
export default {
    name: 'design-system',

    metaInfo() {
        return { title: 'Design system' };
    },

    data() {
        return {
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        };
    },


    computed: {
        isDashboard() {
            return (this.$route.matched.length === 1);
        },

        currentDate() {
            const d = new Date();
            return `${this.months[d.getMonth()]} ${d.getDate()}`;
        },
    },

    methods: {},

};
</script>
