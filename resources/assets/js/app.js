
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('server-panel', require('./components/ServerPanel.vue'));
Vue.component('new-server', require('./components/NewServer.vue'));

const app = new Vue({
    el: '#app'
});