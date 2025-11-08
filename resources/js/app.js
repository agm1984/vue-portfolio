import { createApp } from 'vue';
import { createHead } from '@unhead/vue/client';
import { createPinia } from 'pinia';
// import store from '~/store/index';
import router from '~/router';
import App from '~/components/App.vue';
import '~/plugins';
import './components';
import './components/common';

const app = createApp(App);
const head = createHead();
const pinia = createPinia();

app.use(head);
app.use(router);
app.use(pinia);

app.mount('#app');

export default app;
