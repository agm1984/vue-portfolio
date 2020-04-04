import Vue from 'vue';
import Buefy from 'buefy';
import { extend } from 'vee-validate';
import router from '@/js/routes.js';
import App from '@/js/layouts/App';
import loadInputValidationMessages from './inputValidationMessages';
import './axios';
import './components';

Vue.use(Buefy, {
    defaultIconPack: 'fas',
});

loadInputValidationMessages(extend);

const app = new Vue({
    el: '#root',
    router,
    render: h => h(App),
});

export default app;
