/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import VueEcho from 'vue-echo-laravel';

Vue.use(VueRouter);

import App from './layouts/App.vue';
import router from './router';

const EchoInstance = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true
});

Vue.use(VueEcho, EchoInstance);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
