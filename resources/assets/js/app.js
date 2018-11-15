
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('animate.css');
import axios from 'axios';
import Resource from 'vue-resource';
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'

import vueTopprogress from 'vue-top-progress'

// import Cliens from './components/routes/Clients'

window.Vue = require('vue');

window.axios = axios;

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

window.Mservice = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(Resource)
Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.use(vueTopprogress)

Vue.component('tasks', require('./components/Task'));
// Vue.component('search', require('./components/Search'));
Vue.component('navi', require('./components/Nav'));
Vue.component('results', require('./components/Results'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let routes = [
    { path: '/search/:search', name: 'search', component: require('./components/Results')},
    { path: '/clients/:client', component: require('./components/routes/Clients')},
    { path: '/products/:product', component: require('./components/routes/Product')},
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: '',
        isSearch: false
    },
    created() {
        if(this.$route.params.search) {
            this.search = this.$route.params.search
        } else {
            this.search = ''
        }
    },
    methods: {
        searchit() {
            router.push({ name: 'search', params: { search: this.search } })
            Mservice.$emit('searchit')
            //this.isSearch = true;
        }
    }
});
