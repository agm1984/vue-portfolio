<template>
    <div class="flex w-full h-auto xl:w-1024">
        <div class="sidebar-page">
            <section class="sidebar-layout">
                <b-sidebar
                    type="is-light"
                    mobile="reduce"
                    position="static"
                    expand-on-hover
                    open
                    reduce
                >
                    <div class="">
                        <div class="block">
                            <h2 level="1">
                                Design
                            </h2>
                        </div>
                        <b-menu class="is-custom-mobile">
                            <b-menu-list :label="currentDate">
                                <b-menu-item
                                    label="Dashboard"
                                    tag="router-link"
                                    :to="{ name: 'design' }"
                                    :active="$router.currentRoute.name === 'design'"
                                ></b-menu-item>
                            </b-menu-list>
                            <b-menu-list label="UI Elements">
                                <b-menu-item
                                    label="Buttons"
                                    tag="router-link"
                                    :to="{ name: 'design.buttons' }"
                                    :active="$router.currentRoute.name === 'design.buttons'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Colours"
                                    tag="router-link"
                                    :to="{ name: 'design.colours' }"
                                    :active="$router.currentRoute.name === 'design.colours'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Space & Size"
                                    tag="router-link"
                                    :to="{ name: 'design.sizing' }"
                                    :active="$router.currentRoute.name === 'design.sizing'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Typography"
                                    tag="router-link"
                                    :to="{ name: 'design.typography' }"
                                    :active="$router.currentRoute.name === 'design.typography'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Form controls">
                                <b-menu-item
                                    label="Text inputs"
                                    tag="router-link"
                                    to="/textinputs"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Selects"
                                    tag="router-link"
                                    to="/selects"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Components">
                                <b-menu-item
                                    label="Radical thing"
                                    tag="router-link"
                                    to="/textinputs"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Blast widget"
                                    tag="router-link"
                                    to="/selects"
                                ></b-menu-item>
                            </b-menu-list>
                        </b-menu>
                    </div>
                </b-sidebar>
            </section>
        </div>

        <div class="w-full h-auto pt-64 pl-32">
            <template v-if="isDashboard">
                <router-link :to="{ name: 'design.buttons' }">
                    <a-card class="flex flex-wrap p-32" with-geometry>
                        <div class="flex items-center justify-center w-64 h-64 rounded-full border-1 border-primary">
                            <b-icon
                                pack="fas"
                                icon="mouse-pointer"
                                size="is-medium"
                                type="is-primary">
                            </b-icon>
                        </div>
                        <div class="flex items-center ml-16">
                            <h2 level="2">
                                Buttons
                            </h2>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.colours' }">
                    <a-card class="flex flex-wrap p-32 mt-16" with-geometry>
                        <div class="flex items-center justify-center w-64 h-64 rounded-full border-1 border-primary">
                            <b-icon
                                pack="fas"
                                icon="palette"
                                size="is-medium"
                                type="is-primary">
                            </b-icon>
                        </div>
                        <div class="flex items-center ml-16">
                            <h2 level="2">
                                Colours
                            </h2>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.sizing' }">
                    <a-card class="flex flex-wrap p-32 mt-16" with-geometry>
                        <div class="flex items-center justify-center w-64 h-64 rounded-full border-1 border-primary">
                            <b-icon
                                pack="fas"
                                icon="ruler-combined"
                                size="is-medium"
                                type="is-primary">
                            </b-icon>
                        </div>
                        <div class="flex items-center ml-16">
                            <h2 level="2">
                                Space & Size
                            </h2>
                        </div>
                    </a-card>
                </router-link>

                <router-link :to="{ name: 'design.typography' }">
                    <a-card class="flex flex-wrap p-32 mt-16" with-geometry>
                        <div class="flex items-center justify-center w-64 h-64 rounded-full border-1 border-primary">
                            <b-icon
                                pack="fas"
                                icon="font"
                                size="is-medium"
                                type="is-primary">
                            </b-icon>
                        </div>
                        <div class="flex items-center ml-16">
                            <h2 level="2">
                                Typography
                            </h2>
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
