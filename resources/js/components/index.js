import Vue from 'vue';
import { HasError, AlertError, AlertSuccess } from 'vform';
import Card from './Card.vue';
import child from './child.vue';
import Button from './Button.vue';
import Checkbox from './Checkbox.vue';

// Components that are registered globaly.
[
    Card,
    child,
    Button,
    Checkbox,
    HasError,
    AlertError,
    AlertSuccess,
].forEach((Component) => {
    Vue.component(Component.name, Component);
});
