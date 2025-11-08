import { createApp } from 'vue';
import { createHead } from '@unhead/vue/client';
import Vuex from 'vuex';
// import store from '~/store/index';
import router from '~/router';
import App from '~/components/App.vue';
import '~/plugins';
import './components';
import './components/common';

const app = createApp(App);
const head = createHead();

app
    .use(head)
    .use(router)
    .use(Vuex);

app.mount('#app');

export default app;
