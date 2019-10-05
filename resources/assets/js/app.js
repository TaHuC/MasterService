
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('animate.css');
require("vue-awesome-notifications/dist/styles/style.css")

import axios from 'axios';
import Resource from 'vue-resource';
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'

import vueTopprogress from 'vue-top-progress'
//import Axios from 'axios';
import VueAWN from "vue-awesome-notifications"

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
Vue.use(VueAWN, {
    labels: { 
        alert: 'Решения',
        info: 'Решения',
        confirm: 'Решения'
    },
    modal: {
        'okLabel': 'Не ми напомняй',
        'cancelLabel': 'Отложи за 30мин.'
    }
})

Vue.component('tasks', require('./components/Task'));
Vue.component('navi', require('./components/Nav'));
Vue.component('results', require('./components/Results'));
Vue.component('forparts', require('./components/wigets/ForParts'));
Vue.component('instantly', require('./components/wigets/Instantly'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let routes = [
    { path: '/search/:search', name: 'search', component: require('./components/Results')},
    { path: '/clients/:client', name: 'client', component: require('./components/routes/Clients')},
    { path: '/products/:product', name: 'viewProduct', component: require('./components/routes/Product')},
    { path: '/usersettings', name:'userSettings', component: require('./components/UserSettings')},
    { path: '/app-settings', name:'settings', component: require('./components/Settings')},
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export const bus = new Vue()

$(function () {
    $('[data-toggle="popover"]').popover()
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: '',
        isSearch: false,
        user: null,
        firstUserSetting: false
    },
    created() {
        if(this.$route.params.search) {
            this.search = this.$route.params.search
        } else {
            this.search = ''
        }
        this.getUserInfo()
    },
    methods: {
      getUserInfo() {
           axios.get('/users')
                .then(res => {
                    //console.log(res.data)
                    if (res.data[1] != null) {
                        this.user =  res.data[0]
                    } else {
                       this.createUserSettings() 
                    }
                })
                .catch(err => console.log(err.response))
        },
        createUserSettings() {
            axios({
                method: 'POST',
                url: '/api/usersettings',
                data: {
                    'color': '#00000'
                }
            })
            .then(res => {
                this.getUserInfo()
                router.push({name: 'userSettings'})
            })
            .catch(err => console.log(err.response))
        },
        addNewClient() {
            router.push({ name: 'client', params: {'client': 'addCl'}});
            Mservice.$emit('addNewClient')
        },
        searchit() {
            if(this.search) {
            router.push({ name: 'search', params: { search: this.search } })
            Mservice.$emit('searchit')
            //this.isSearch = true;
            } else {
                return
            }
        }
    }
});

