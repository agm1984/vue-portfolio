import Vue from 'vue';
import Buefy from 'buefy';
import { extend } from 'vee-validate';
import route from 'ziggy';
import store from '~/store/index';
import router from '~/router';
import App from '~/components/App.vue';
import loadInputValidationMessages from './inputValidationMessages';
import '~/plugins';
import './components';
import './components/common';

Vue.use(Buefy, {
    defaultIconPack: 'fas',
});

loadInputValidationMessages(extend);

Vue.mixin({
    methods: {
        route,
    },
});

Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    router,
    store,
    ...App,
});

export default app;
