import Vue from 'vue';

Vue.component('a-form', () => import(/* webpackChunkName: 'a-form' */ './a-form.vue'));
Vue.component('a-sacred-geometry', () => import(/* webpackChunkName: 'a-sacred-geometry' */ './a-sacred-geometry.vue'));
Vue.component('a-text-input', () => import(/* webpackChunkName: 'a-text-input' */ './a-text-input.vue'));
Vue.component('a-tilt', () => import(/* webpackChunkName: 'a-tilt' */ './a-tilt.vue'));
