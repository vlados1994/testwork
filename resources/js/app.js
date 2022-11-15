/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import {createStore} from 'vuex'

const store = createStore({
    state() {
        return {}
    },
    mutations: {},
    actions: {
        async getServices() {
            const response = await axios.get('/api/services', {});

            return response.data.data;
        },
        async getUsers(context, type = '') {
            let url = '/api/users?';

            if (type) {
                url += 'type=' + type;
            }

            const response = await axios.get(url, {});

            return response.data.data;
        },
    }
})

app.use(store)

app.component('Datepicker', Datepicker);

const vuetify = createVuetify({
    components,
    directives,
})

app.use(vuetify);

axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('authtoken');

        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);

import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    {
        path: '/registration',
        name: "registration",
        component: () => import('./pages/registration.vue')
    },
    {
        path: '/user-page',
        name: "user-page",
        component: () => import('./pages/user-page.vue')
    },
    {
        path: '/dentist-page',
        name: "dentist-page",
        component: () => import('./pages/dentist-page.vue')
    },
    {
        path: '/admin-login',
        name: "admin-login",
        component: () => import('./pages/admin-login.vue')
    },
    {
        path: '/admin',
        name: "admin",
        component: () => import('./pages/admin.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


app.use(router);

import ExampleComponent from './components/ExampleComponent.vue';

app.component('example-component', ExampleComponent);


//app.component('registration', registration);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
