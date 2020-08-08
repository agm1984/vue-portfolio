import Vue from 'vue';
import store from '~/store/index';
import router from '~/router';
import App from '~/components/App.vue';
import '~/plugins';
import './components';
import './components/common';

Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    router,
    store,
    ...App,
});

export default app;
