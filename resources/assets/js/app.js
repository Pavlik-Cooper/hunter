
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.moment = require('moment');
import { store } from './store.js';
import Toastr from 'vue-toastr';
require('vue-toastr/src/vue-toastr.scss');
// Register plugin
Vue.use(Toastr);
Vue.use(require('vue-chat-scroll'));
// authorizations is an object
let authorizations = require('./authorizations');

Vue.prototype.authorize = function (...params) {
    if (!window.App.signedIn) return false;

    if (typeof params[0] === 'string') {
        // authorizations is an object, hence, the 1st param is its method
        return authorizations[params[0]](params[1])
    }
    // return handler(user => user.id === whatever.user_id) (callback());
    return params[0](window.App.user);

};
Vue.prototype.signedIn = window.App.signedIn;
// Vue.prototype.User = window.App.user;

Vue.component('flash',require('./components/flash.vue'));

Vue.component('thread-view', require('./components/thread-view.vue'));
Vue.component('newreply', require('./components/newreply.vue'));
Vue.component('avatar-form', require('./components/avatar-form.vue'));
Vue.component('notification', require('./components/notification.vue'));
Vue.component('chat', require('./components/chat.vue'));

import Echo from "laravel-echo";
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ed4b3aaeea136a83cf33',
    cluster: 'eu',
    encrypted: true
});

const app = new Vue({
    el: '#app',
    store,
});
