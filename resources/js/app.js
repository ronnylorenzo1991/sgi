require('./bootstrap')
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './router/routes';
import VueSweetalert2 from 'vue-sweetalert2';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import {Ziggy} from './routes'
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.component('loader', require('./components/utils/loader.vue').default);
Vue.component('multi_select', require('./components/utils/multiselect.vue').default);

Vue.use(VueSweetalert2);

Vue.prototype.can = function(value){
    return window.Laravel.jsPermissions.permissions.includes(value);
}
Vue.prototype.is = function(value){
    return window.Laravel.jsPermissions.roles.includes(value);
}

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    name: 'App',
    router,
    LaravelPermissionToVueJS,
    el: '#app'
})
