import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/components/Home.vue';
import Skills from '@/js/components/Skills.vue';
import Examples from '@/js/components/Examples.vue';
import Story from '@/js/components/Story.vue';
import Contact from '@/js/components/Contact.vue';

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
