import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/pages/Home.vue';
import Skills from '@/js/components/skills/Skills.vue';
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
            path: '/story',
            name: 'story',
            component: Story,
            // An approximate history and story about Adam Mackintosh
        },
        {
            path: '/skills',
            name: 'skills',
            component: Skills,
            // See some of Adam's skills
        },
        {
            path: '/examples',
            name: 'examples',
            component: Examples,
            // Examples from Adam Mackintosh
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
            // Start a conversation with Adam
        },
    ],
});

export default router;
