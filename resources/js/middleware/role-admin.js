import Swal from 'sweetalert2';
import store from '~/store/index';

const Roles = {
    ADMIN: 'admin',
};

/**
 * Checks if a user has the `admin` Role, and otherwise halts the request
 * and displays a permission-denied dialog if the user isn't an `admin`.
 *
 * This middleware expects to be used after the `auth` middleware
 * @example
 * // a-component.vue
 * <script>
 * export default {
 *     middleware: ['auth', 'role-admin'],
 * };
 * </script>
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
 * @return {Function}
 */
const roleAdmin = (to, from, next) => {
    if (store.getters['auth/check'] && store.getters['auth/user'].roles_list.includes(Roles.ADMIN)) {
        return next();
    }

    return Swal.fire({
        icon: 'warning',
        title: 'Unauthorized!',
        text: 'You don\'t have permission to access this page.',
        confirmButtonText: 'Ok',
    }).then(() => next({ path: from.fullPath }));
};

export default roleAdmin;
