import { useToast } from 'primevue/usetoast';
import { useAuthStore } from '~/store/auth';

export async function metaAuthGuard(to, from, next) {
    const toast = useToast();
    const auth = useAuthStore();

    if (!auth.isInitialized) {
        await auth.fetchUser();
    }

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
            toast.add({ severity: 'warn', summary: 'Permission denied', detail: 'You do not have the required permissions to access this page.', life: 5000 });
            return next({ name: '403' });
        }
    }

    return next();
}
