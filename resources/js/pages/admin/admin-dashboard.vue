<template>
    <div class="flex w-full h-auto p-8">
        <div class="min-w-[125px] flex flex-col gap-4">
            <h1>Admin</h1>

            <div>
                <router-link
                    :to="{ name: 'admin' }"
                    :active="$router.currentRoute.name === 'admin'"
                >Dashboard</router-link>
            </div>

            <div>
                <router-link
                    :to="{ name: 'admin.users.list' }"
                    :active="$router.currentRoute.name === 'admin.users.list'"
                >List Users</router-link>
            </div>

            <div>
                <router-link
                    :to="{ name: 'admin.categories.list' }"
                    :active="$router.currentRoute.name === 'admin.categories.list'"
                >List Categories</router-link>
            </div>

            <div>
                <router-link
                    :to="{ name: 'admin.categories.create' }"
                    :active="$router.currentRoute.name === 'admin.categories.create'"
                >Add Category</router-link>
            </div>

            <div>
                <router-link
                    :to="{ name: 'admin.examples.list' }"
                    :active="$router.currentRoute.name === 'admin.examples.list'"
                >List Examples</router-link>
            </div>

            <div>
                <router-link
                    :to="{ name: 'admin.examples.create' }"
                    :active="$router.currentRoute.name === 'admin.examples.create'"
                >Add Example</router-link>
            </div>
        </div>

        <div class="w-full h-auto ml-8">
            <div v-if="isDashboard" class="w-full grid grid-cols-3 gap-8">
                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Categories
                    </h2>
                    <span class="text-5xl">8</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Examples
                    </h2>
                    <span class="text-5xl">12</span>
                </a-card>

                <a-card class="flex flex-row items-center justify-between p-16">
                    <h2 level="2">
                        Users
                    </h2>
                    <span class="text-5xl">32</span>
                </a-card>
            </div>
            <a-card v-if="isDashboard" class="p-8 mt-8" with-geometry>
                <h2 level="2">
                    Dashboard
                </h2>

                <div>
                    <!-- <apexchart
                        type="line"
                        :options="options"
                        :series="series"
                    ></apexchart> -->
                </div>
            </a-card>

            <router-view v-else></router-view>
        </div>

        <!-- <div class="flex flex-col p-8">
            <h2 level="1">Categories</h2>

            <router-link :to="{ name: 'admin.categories.list' }" class="ml-16 nav-link-white">
                List categories
            </router-link>
            <router-link to="/admin/categories/create" class="ml-16 nav-link-white">Add category</router-link>
        </div>

        <div class="flex flex-col p-8">
            <h2 level="1">Examples</h2>

            <router-link :to="{ name: 'admin.examples.list' }" class="ml-16 nav-link-white">
                List examples
            </router-link>
            <router-link to="/admin/examples/create" class="ml-16 nav-link-white">Add example</router-link>
        </div>

        <div class="flex flex-col p-8">
            <h2 level="1">Users</h2>

            <router-link :to="{ name: 'admin.users.list' }" class="ml-16 nav-link-white">
                List users
            </router-link>
            <router-link to="/admin/users/create" class="ml-16 nav-link-white">Add user</router-link>
        </div> -->
    </div>
</template>

<script>
// import VueApexCharts from 'vue-apexcharts';

const INITIAL = 'INITIAL';
const LOADED = 'LOADED';

export default {
    name: 'admin-dashboard',

    components: {
        // apexchart: VueApexCharts,
    },

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
