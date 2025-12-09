import router from '~/router';
import { useToast } from '~/composables/useToast';
import createApiClient from '~/plugins/axios';

export const api = createApiClient({
    router,
    toast: useToast(),
});
