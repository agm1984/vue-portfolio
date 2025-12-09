import { createApp } from 'vue';
import { createHead } from '@unhead/vue/client';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';
import { definePreset } from '@primevue/themes';
import Aura from '@primeuix/themes/aura';
import App from '~/components/App.vue';
import router from '~/router';
import { useToast } from '~/composables/useToast';
import '~/plugins';
import 'primeicons/primeicons.css';

const app = createApp(App);
const head = createHead();
const pinia = createPinia();

const Noir = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{indigo.50}',
            100: '{indigo.100}',
            200: '{indigo.200}',
            300: '{indigo.300}',
            400: '{indigo.400}',
            500: '{indigo.500}',
            600: '{indigo.600}',
            700: '{indigo.700}',
            800: '{indigo.800}',
            900: '{indigo.900}',
            950: '{indigo.950}'
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{indigo.950}',
                    inverseColor: '#ffffff',
                    hoverColor: '{indigo.900}',
                    activeColor: '{indigo.800}'
                },
                highlight: {
                    background: '{indigo.950}',
                    focusBackground: '{indigo.700}',
                    color: '#ffffff',
                    focusColor: '#ffffff'
                }
            },
            dark: {
                primary: {
                    color: '{indigo.50}',
                    inverseColor: '{indigo.950}',
                    hoverColor: '{indigo.100}',
                    activeColor: '{indigo.200}'
                },
                highlight: {
                    background: 'rgba(250, 250, 250, .16)',
                    focusBackground: 'rgba(250, 250, 250, .24)',
                    color: 'rgba(255,255,255,.87)',
                    focusColor: 'rgba(255,255,255,.87)'
                }
            }
        }
    }
});

app.use(head);
app.use(router);
app.use(pinia);
app.use(PrimeVue, {
    theme: {
        preset: Noir,
        options: {
            darkModeSelector: '.dark',
            cssLayer: {
                name: 'primevue',
                order: 'theme, base, primevue',
            },
        },
    },
});
app.use(ToastService);
app.use(ConfirmationService);

app.directive('tooltip', Tooltip);

app.mount('#app');

export default app;
