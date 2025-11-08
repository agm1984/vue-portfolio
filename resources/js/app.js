import { createApp } from 'vue';
import { createHead } from '@unhead/vue/client';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import router from '~/router';
import App from '~/components/App.vue';
import '~/plugins';
import 'primeicons/primeicons.css';
import 'vue3-toastify/dist/index.css';

const app = createApp(App);
const head = createHead();
const pinia = createPinia();

app.use(head);
app.use(router);
app.use(pinia);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
});

app.mount('#app');

export default app;
