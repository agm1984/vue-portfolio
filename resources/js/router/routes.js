/**
 * This utility transforms a Vue component's relative file path into a dynamic-imported component.
 *
 * @param {String} path
 * @returns {Function}
 */
function page(path) {
    return () => import('~/pages/' + path).then(m => m.default || m); // eslint-disable-line prefer-template
}

const router = [
    { path: '/', name: 'home', component: page('home/home.vue') },
    { path: '/about', name: 'about', component: page('aboutMe/about-me.vue') },
    { path: '/examples', name: 'examples', component: page('examples/examples.vue') },
    { path: '/contact', name: 'contact', component: page('contact/contact.vue') },

    { path: '/login', name: 'login', component: page('auth/login.vue') },
    { path: '/register', name: 'register', component: page('auth/register.vue') },
    { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
    { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
    { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

    {
        path: '/settings',
        component: page('settings/index.vue'),
        children: [
            { path: '', redirect: { name: 'settings.profile' } },
            { path: 'profile', name: 'profile', component: page('profile/profile.vue') },
            { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
        ],
    },

    { path: '/admin', name: 'admin', component: page('admin/admin-dashboard.vue') },
    { path: '/admin/categories', name: 'admin.categories.list', component: page('admin/categories/list-categories.vue') },
    { path: '/admin/categories/create', name: 'admin.categories.create', component: page('admin/categories/create-category.vue') },
    { path: '/admin/categories/:category', name: 'admin.categories.show', component: page('admin/categories/show-category.vue') },
    { path: '/admin/examples', name: 'admin.examples.list', component: page('admin/examples/list-examples.vue') },
    { path: '/admin/users', name: 'admin.users.list', component: page('admin/users/list-users.vue') },

    { path: '/design', name: 'design', component: page('design/design-system.vue') },
    { path: '/snippets', name: 'snippets', component: page('snippets/snippets.vue') },

    { path: '*', name: 'splat', component: page('errors/404.vue') },
];

export default router;
