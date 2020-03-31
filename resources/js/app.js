import Vue from 'vue';
import router from '@/js/routes.js';
import App from '@/js/views/App';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App),
});

export default app;
