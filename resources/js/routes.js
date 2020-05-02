import Vue from 'vue';
import VueRouter from 'vue-router';
import AdminDashboard from '@/js/components/admin/admin-dashboard.vue';
import Home from '@/js/pages/Home.vue';
import Skills from '@/js/components/skills/Skills.vue';
import ListExamples from '@/js/pages/list-examples.vue';
import ShowExample from '@/js/pages/show-example.vue';
import Story from '@/js/pages/Story.vue';
import Contact from '@/js/pages/Contact.vue';
import DesignSystem from '@/js/components/designSystem/design-system.vue';
import Error404 from '@/js/pages/a-404.vue';

// https://markus.oberlehner.net/blog/vue-router-page-transitions/

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',

    routes: [
        // admin routes
        {
            path: '/admin',
            name: 'admin',
            component: AdminDashboard,
        },
        {
            path: '/admin/categories',
            name: 'list-categories',
            component: AdminDashboard,
        },

        // public routes
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/story',
            name: 'story',
            component: Story,
        },
        {
            path: '/skills',
            name: 'skills',
            component: Skills,
        },
        {
            path: '/examples',
            name: 'list-examples',
            component: ListExamples,
            children: [
                {
                    path: '/examples/:categorySlug',
                    name: 'list-examples-for-category',
                    component: ListExamples,
                },
            ],
        },
        {
            path: '/examples/:categorySlug/:exampleSlug',
            name: 'examples3',
            component: ShowExample,
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
        },
        {
            path: '/design',
            name: 'designSystem',
            component: DesignSystem,
        },

        {
            // splat route
            path: '*',
            name: '404',
            component: Error404,
        },
    ],

    scrollBehavior(to, from, savedPosition) { // eslint-disable-line no-unused-vars
        return new Promise(resolve => this.app.$once('scrollAfterEnter', () => {
            if (savedPosition) {
                return resolve(savedPosition);
            }

            return resolve({ x: 0, y: 0 });
        }));
    },

});

Vue.directive('title', {
    inserted(el, binding) { // eslint-disable-line no-unused-vars
        if (!binding.value) return;
        document.title = `${binding.value} | Adam Mackintosh's portfolio`;
    },

    update(el, binding) { // eslint-disable-line no-unused-vars
        if (!binding.value) return;
        document.title = `${binding.value} | Adam Mackintosh's portfolio`;
    },
});

export default router;
