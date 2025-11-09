import { useAuthStore } from '~/store/auth';
import { toast } from 'vue3-toastify';

export async function metaAuthGuard(to, from, next) {
  const auth = useAuthStore();

  // Only try to preload "me" if:
  // - the route requires auth, or
  // - we already think we’re logged in (persisted state)
  if (to.meta?.requiresAuth && !auth.check) {
    try {
      await auth.fetchUser();   // your Pinia action
    } catch (_) {
      // fetchUser() already does _logout(); swallow 401 quietly
    }
  }

  // guest-only
  if (to.meta?.guestOnly && auth.check) {
    await auth.fetchUser();
    return next(to.meta.redirectLoggedInTo ?? { name: 'home' });
  }

  // require auth
  if (to.meta?.requiresAuth && !auth.check) {
    if (to.fullPath?.length > 1) auth.setIntendedUrl(to.fullPath);
    return next({ name: 'login' });
  }

  // roles
  if (Array.isArray(to.meta?.roles) && to.meta.roles.length) {
    const userRoles =
      auth.user?.roles_list ??
      auth.user?.roles?.map(r => (typeof r === 'string' ? r : r.name)) ??
      [];
    const hasRole = to.meta.roles.some(r => userRoles.includes(r));
    if (!hasRole) {
      toast.warning('You don\'t have permission to access this page.');
      // todo: show a 403 page instead
      return next(from.fullPath ? { path: from.fullPath } : { name: 'home' });
    }
  }

  return next();
}
