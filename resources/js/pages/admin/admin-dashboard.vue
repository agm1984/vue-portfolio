<template>
    <div class="flex w-full h-auto xl:w-1280">
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
                                Admin
                            </h2>
                        </div>

                        <b-menu class="is-custom-mobile">
                            <b-menu-list :label="currentDate">
                                <b-menu-item
                                    label="Dashboard"
                                    tag="router-link"
                                    :to="{ name: 'admin' }"
                                    :active="$router.currentRoute.name === 'admin'"
                                ></b-menu-item>
                            </b-menu-list>
                            <b-menu-list label="Users">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.users.list' }"
                                    :active="$router.currentRoute.name === 'admin.users.list'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Categories">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.categories.list' }"
                                    :active="$router.currentRoute.name === 'admin.categories.list'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Add"
                                    tag="router-link"
                                    :to="{ name: 'admin.categories.create' }"
                                    :active="$router.currentRoute.name === 'admin.categories.create'"
                                ></b-menu-item>
                            </b-menu-list>

                            <b-menu-list label="Examples">
                                <b-menu-item
                                    label="List"
                                    tag="router-link"
                                    :to="{ name: 'admin.examples.list' }"
                                    :active="$router.currentRoute.name === 'admin.examples.list'"
                                ></b-menu-item>
                                <b-menu-item
                                    label="Add"
                                    tag="router-link"
                                    :to="{ name: 'admin.examples.create' }"
                                    :active="$router.currentRoute.name === 'admin.examples.create'"
                                ></b-menu-item>
                            </b-menu-list>

                        </b-menu>
                    </div>
                </b-sidebar>
            </section>
        </div>

        <div class="w-full h-auto pt-64 pl-32">
            <div v-if="isDashboard" class="flex items-center pb-16">
                <a-card class="flex flex-row items-center justify-between w-1/3 p-32" with-geometry>
                    <h2 level="2">
                        Categories
                    </h2>
                    <span class="text-xl">8</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between w-1/3 p-32 mx-16" with-geometry>
                    <h2 level="2">
                        Examples
                    </h2>
                    <span class="text-xl">12</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between w-1/3 p-32" with-geometry>
                    <h2 level="2">
                        Users
                    </h2>
                    <span class="text-xl">32</span>
                </a-card>
            </div>
            <a-card v-if="isDashboard" class="p-32" with-geometry>
                <h2 level="2">
                    Dashboard
                </h2>

                <div>
                    <apexchart
                        type="line"
                        :options="options"
                        :series="series"
                    ></apexchart>
                </div>
            </a-card>

            <router-view v-else></router-view>
        </div>

        <!-- <div class="flex flex-col p-32">
            <h2 level="1">Categories</h2>

            <router-link :to="{ name: 'admin.categories.list' }" class="ml-16 nav-link-white">
                List categories
            </router-link>
            <router-link to="/admin/categories/create" class="ml-16 nav-link-white">Add category</router-link>
        </div>

        <div class="flex flex-col p-32">
            <h2 level="1">Examples</h2>

            <router-link :to="{ name: 'admin.examples.list' }" class="ml-16 nav-link-white">
                List examples
            </router-link>
            <router-link to="/admin/examples/create" class="ml-16 nav-link-white">Add example</router-link>
        </div>

        <div class="flex flex-col p-32">
            <h2 level="1">Users</h2>

            <router-link :to="{ name: 'admin.users.list' }" class="ml-16 nav-link-white">
                List users
            </router-link>
            <router-link to="/admin/users/create" class="ml-16 nav-link-white">Add user</router-link>
        </div> -->
    </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts';

const INITIAL = 'INITIAL';
const LOADED = 'LOADED';

export default {
    name: 'admin-dashboard',

    components: {
        apexchart: VueApexCharts,
    },

    middleware: ['auth', 'role-admin'],

    metaInfo() {
        return { title: 'Dashboard' };
    },

    data() {
        return {
            state: INITIAL,
            options: {
                chart: {
                    id: 'vuechart-example',
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
                },
            },
            series: [{
                name: 'series-1',
                data: [30, 40, 45, 50, 49, 60, 70, 91],
            }],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        };
    },

    computed: {
        isDashboard() {
            return (this.$route.matched.length === 1);
        },

        isLoaded() {
            return (this.state === LOADED);
        },

        currentDate() {
            const d = new Date();
            return `${this.months[d.getMonth()]} ${d.getDate()}`;
        },
    },

    mounted() {
        // this.renderChart(this.chartdata, this.options);
    },

    methods: {
        async fetchChart() {
            try {
                // const { data } = await axios.get(route('admin.categories.list'));

                const data = [40, 20];

                console.log('chart data', data);

                this.chartdata.datasets[0].data = data;
                this.state = LOADED;
            } catch (err) {
                throw new Error(`admin-dashboard# Problem fetching chart data: ${err}.`);
            }
        },
    },

};
</script>
