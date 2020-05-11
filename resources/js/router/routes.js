function page(path) {
    return () => import(/* webpackChunkName: '' */ '~/pages/' + path).then(m => m.default || m); // eslint-disable-line prefer-template
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
            { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
            { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
        ],
    },

    { path: '/admin', name: 'admin', component: page('admin/admin-dashboard.vue') },

    { path: '/design', name: 'design', component: page('design/design-system.vue') },

    { path: '*', component: page('errors/404.vue') },
];

export default router;
