import { useAuthStore } from '~/store/auth';
import { toast } from 'vue3-toastify';

export async function metaAuthGuard(to, from, next) {
    const auth = useAuthStore();
    await auth.fetchUser();

    // guest-only
    if (to.meta?.guestOnly) {
        if (!auth.isAuthenticated) return next();
        return next(to.meta.redirectLoggedInTo ?? { name: 'home' });
    }

    // require auth
    if (to.meta?.requiresAuth && !auth.isAuthenticated) {
        return next({ name: 'login', query: { redirect: to.fullPath } });
    }

    // roles
    if (to.meta?.roles?.length) {
        const hasRole = to.meta.roles.some(r => auth.user.roles_list.includes(r));

        if (!hasRole) {
            toast.warning('Permission denied');
            return next({ name: '403' });
        }
    }

    return next();
}
