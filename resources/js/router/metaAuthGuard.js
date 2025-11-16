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
    if (Array.isArray(to.meta?.roles) && to.meta.roles.length) {
        const userRoles =
            auth.user?.roles_list ??
            auth.user?.roles?.map(r => (typeof r === 'string' ? r : r.name)) ??
            [];

        const hasRole = to.meta.roles.some(r => userRoles.includes(r));

        if (!hasRole) {
            toast.warning('Permission denied');
            return next({ name: '403' });
        }
    }

    return next();
}
