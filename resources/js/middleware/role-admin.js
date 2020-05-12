import Swal from 'sweetalert2';
import store from '~/store/index';

const Roles = {
    ADMIN: 'admin',
};

const roleAdmin = (to, from, next) => {
    if (store.getters['auth/user'].roles_list.includes(Roles.ADMIN)) {
        return next();
    }

    return Swal.fire({
        icon: 'warning',
        title: 'Unauthorized!',
        text: 'You don\'t have permission to access this.',
        confirmButtonText: 'Ok',
    }).then(() => next(false)); // stop navigation event
};

export default roleAdmin;
