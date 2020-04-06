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

/**
 * Global event bus
 * this.$eventHub.$on('some-event-type', data => this.handleEvent(data));
 * this.$eventHub.$emit('some-event-type', data);
 */

Vue.prototype.$eventHub = new Vue();

const app = new Vue({
    el: '#root',
    router,
    render: h => h(App),
});

export default app;
