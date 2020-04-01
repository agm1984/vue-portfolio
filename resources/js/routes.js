import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/pages/Home.vue';
import Skills from '@/js/pages/Skills.vue';
import Examples from '@/js/pages/Examples.vue';
import Story from '@/js/pages/Story.vue';
import Contact from '@/js/pages/Contact.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/skills',
            name: 'skills',
            component: Skills,
        },
        {
            path: '/examples',
            name: 'examples',
            component: Examples,
        },
        {
            path: '/story',
            name: 'story',
            component: Story,
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
        },
    ],
});

export default router;
