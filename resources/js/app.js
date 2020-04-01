import Vue from 'vue';
import router from '@/js/routes.js';
import App from '@/js/layouts/App';

const app = new Vue({
    el: '#root',
    router,
    render: h => h(App),
});

export default app;
