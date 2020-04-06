import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/pages/Home.vue';
import Skills from '@/js/components/skills/Skills.vue';
import ListExamples from '@/js/pages/list-examples.vue';
import ShowExample from '@/js/pages/show-example.vue';
import Story from '@/js/pages/Story.vue';
import Contact from '@/js/pages/Contact.vue';
import Error404 from '@/js/pages/a-404.vue';

// https://markus.oberlehner.net/blog/vue-router-page-transitions/

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
            // An approximate history and story about Adam Mackintosh
            path: '/story',
            name: 'story',
            component: Story,
        },
        {
            // See some of Adam's skills
            path: '/skills',
            name: 'skills',
            component: Skills,
        },
        {
            // Examples from Adam Mackintosh
            path: '/examples',
            name: 'examples1',
            component: ListExamples,
            children: [
                {
                    path: '/examples/:categorySlug',
                    name: 'examples2',
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
            // Start a conversation with Adam
            path: '/contact',
            name: 'contact',
            component: Contact,
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

export default router;
