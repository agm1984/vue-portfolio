# Adam's portfolio

> The `vue-router` config is mostly a series of algorithms that make the client-side simple to work with.

## Global middleware

If you need to add global middleware, add them to `globalMiddleware` in `index.js`.

## Component middleware

If you need to add a middleware to any Vue component, you can add the `middleware` property, for example:

``` vue
<script>
export default {
    name: 'list-admin-stuff',

    middleware: 'role-admin',

    data() {
        return {};
    },

    computed: {},

    methods: {},
};
</script>
```

The `middleware` Vue instance property can also accept an array of middlewares:

```vue
middleware: ['role-admin', 'role-manager'],
```

## Component ScrollToTop

A `scrollToTop` Vue instance prop can be declared to disable scrollToTop in cases where `vue-router` may
do that, such as when pressing the browser back button while scrolled down.

``` vue
<script>
export default {
    name: 'list-admin-stuff',

    scrollToTop: false,

    data() {
        return {};
    },

    computed: {},

    methods: {},
};
</script>
```
