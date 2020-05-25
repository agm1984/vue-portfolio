import Swal from 'sweetalert2';
import store from '~/store/index';

const Roles = {
    ADMIN: 'admin',
};

/**
 * Checks if a user has the 'admin' Role, and otherwise
 * halts the request and displays a permission-denied dialog.
 *
 * @param {Object} to
 * @param {Object} from
 * @param {Function} next
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
