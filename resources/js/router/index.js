import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';
import { metaAuthGuard } from './metaAuthGuard';

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        if (to.hash) {
            return {
                el: to.hash,
                behavior: 'smooth',
            };
        }

        return { top: 0, left: 0 };
    }
});

router.beforeEach(metaAuthGuard);

export default router;
