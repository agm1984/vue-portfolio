import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// load all modules in `modules` folder
const requireContext = require.context('./modules', false, /.*\.js$/);

const modules = requireContext.keys()
    .map(file => [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)])
    .reduce((acc, [name, module]) => {
        if (module.namespaced === undefined) {
            module.namespaced = true;
        }

        return {
            ...acc,
            [name]: module,
        };
    }, {});

export default new Vuex.Store({
    modules,
});
