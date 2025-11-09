import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';
import { metaAuthGuard } from './metaAuthGuard';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(metaAuthGuard);

export default router;
