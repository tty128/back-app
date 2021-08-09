import VueRouter from 'vue-router';
import MainComponent from "./components/Main.vue";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//const { default: VueRouter } = require('vue-router');

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('laravel-main', require('./components/Main.vue').default);
Vue.component('laravel-main-handle', require('./components/MainHandle.vue').default);
Vue.component('laravel-sidebar', require('./components/Sidebar.vue').default);
Vue.component('laravel-modal', require('./components/ElementModal.vue').default);
Vue.component('laravel-input-button', require('./components/InputButtonList.vue').default);
Vue.component('laravel-preview', require('./components/Preview.vue').default);
Vue.component('laravel-element-card', require('./components/ElementCard.vue').default);
Vue.component('laravel-pagination', require('./components/Pagination.vue').default);
Vue.component('laravel-pagination-limit', require('./components/PaginateLimitButton.vue').default);
Vue.component('laravel-manage-header', require('./components/ManageHeader.vue').default);
Vue.component('laravel-vue-csrf', require('./components/VueCSRF.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
    methods: {
        $isSetable: function ($var) {
            return !isNaN($var) && typeof($var) !== null && typeof($var) !== 'undefined'
        }
    }
})


Vue.prototype.$appRootPath = '';
const vue_route_path = '/';
Vue.prototype.$appApiPrefix = '/api/manage';


Vue.prototype.$appPath = vue_route_path;
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: vue_route_path + '/post',
            name: 'post.list',
            component: MainComponent ,
        },
        {
            path: vue_route_path + '/term',
            name: 'term.list',
            component: MainComponent ,
        }
    ]
});

const app = new Vue({
    el: '#app',
    methods: {
        getJson: function (routePath) {
            let json = null
            let path = routePath
            path = path.replace(this.$appPath , this.$appApiPrefix)
            path = this.$appRootPath + path

            axios
            .get(path)
            .then(response => (json = response.data))

            return json
        }
    },
    router
});
