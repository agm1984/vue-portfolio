const routes = [
    { path: '/', name: 'home', meta: { preloadOnly: true }, component: () => import('../pages/home/home.vue') },
    { path: '/about', name: 'about', meta: { preloadOnly: true }, component: () => import('../pages/aboutMe/about-me.vue') },
    { path: '/skills', name: 'skills', meta: { preloadOnly: true }, component: () => import('../pages/skills/skills.vue') },
    {
        path: '/examples',
        name: 'public.examples',
        component: () => import('../pages/examples/examples.vue'),
        redirect: { name: 'public.examples.list' },
        children: [
            { path: ':category?', name: 'public.examples.list', component: () => import('../pages/examples/list-examples.vue') },
            { path: ':category/:example', name: 'public.examples.show', component: () => import('../pages/examples/show-example.vue') },
            { path: ':category/:example/images/:filename', name: 'public.examples.images', component: () => import('../pages/examples/show-example-images.vue') },
        ],
    },

    { path: '/contact', name: 'contact', meta: { preloadOnly: true }, component: () => import('../pages/contact/contact.vue') },

    { path: '/login', name: 'login', meta: { guestOnly: true }, component: () => import('../pages/auth/login.vue') },
    { path: '/register', name: 'register', meta: { guestOnly: true }, component: () => import('../pages/auth/register.vue') },
    { path: '/password/reset', name: 'password.request', component: () => import('../pages/auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: () => import('../pages/auth/password/reset.vue') },
    { path: '/email/verify/:id', name: 'verification.verify', component: () => import('../pages/auth/verification/verify.vue') },
    { path: '/email/resend', name: 'verification.resend', component: () => import('../pages/auth/verification/resend.vue') },

    {
        path: '/settings',
        meta: { requiresAuth: true },
        component: () => import('../pages/profile/profile-index.vue'),
        children: [
            { path: '', redirect: { name: 'settings.profile' } },
            { path: 'profile', name: 'settings.profile', component: () => import('../pages/profile/edit-profile.vue') },
            { path: 'password', name: 'settings.password', component: () => import('../pages/profile/edit-password.vue') },
        ],
    },

    {
        path: '/admin',
        name: 'admin',
        meta: { requiresAuth: true, roles: ['admin'] },
        component: () => import('../pages/admin/admin-dashboard.vue'),
        children: [
            { path: 'users', name: 'admin.users.list', component: () => import('../pages/admin/users/list-users.vue') },
            { path: 'users/:user', name: 'admin.users.show', component: () => import('../pages/admin/users/show-user.vue') },
            { path: 'categories', name: 'admin.categories.list', component: () => import('../pages/admin/categories/list-categories.vue') },
            { path: 'categories/create', name: 'admin.categories.create', component: () => import('../pages/admin/categories/create-category.vue') },
            { path: 'categories/:category', name: 'admin.categories.show', component: () => import('../pages/admin/categories/show-category.vue') },
            { path: 'examples', name: 'admin.examples.list', component: () => import('../pages/admin/examples/list-examples.vue') },
            { path: 'examples/create', name: 'admin.examples.create', component: () => import('../pages/admin/examples/create-example.vue') },
            { path: 'examples/:example', name: 'admin.examples.show', component: () => import('../pages/admin/examples/show-example.vue') },
        ],
    },

    {
        path: '/design',
        name: 'design',
        component: () => import('../pages/design/design-dashboard.vue'),
        children: [
            { path: 'buttons', name: 'design.buttons', component: () => import('../pages/design/buttons.vue') },
            { path: 'colours', name: 'design.colours', component: () => import('../pages/design/colours.vue') },
            { path: 'sizing', name: 'design.sizing', component: () => import('../pages/design/sizing.vue') },
            { path: 'typography', name: 'design.typography', component: () => import('../pages/design/typography.vue') },
        ],
    },

    { path: '/forbidden', name: '403', component: () => import('../pages/errors/403.vue') },
    { path: '/:catchAll(.*)', name: 'splat', component: () => import('../pages/errors/404.vue') },
];

export default routes;
