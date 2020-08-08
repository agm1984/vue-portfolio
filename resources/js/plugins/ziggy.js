/**
 * Ziggy brings Laravel's `route()` function into JavaScript.
 *
 * @link https://github.com/tightenco/ziggy#usage
 * @example route('oauth.callback', 'github')
 * @example route('admin.accounts.update', this.account.id)
 * @example route('admin.users.update', [this.account.id, this.user.id])
 *
 * A note about Route Key Names:
 * JavaScript `route()` syntax is usually near 1:1 with Laravel, but Ziggy does not support route key names other
 * than `id` when using short-hand. For example, when a Laravel model such as the User model is using a route key name
 * other than `id` such as `username`, Ziggy is not smart enough to auto-transform `route('name', this.user)` into
 * `route('name', this.user.username)`. This issue can crop up if a route-key is changed from `id` after initial
 * development. For this reason, I tend to prefer explicitly-declaring every model's route key name in JavaScript.
 *
 * Ziggy's exported routes are made available as `this.route` via a global mixin. In DOM templates, you can use
 * `route()`, and in any Vue instance, you can use `this.route()`.
 *
 * Note: all of this is powered by the `@routes` directive in the root layout, `spa.blade.php`.
 */
import Vue from 'vue';
import route from 'ziggy';

Vue.mixin({
    methods: {
        route,
    },
});
