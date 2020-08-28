
require('./bootstrap');

window.Vue = require('vue');

// Support vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index"
const store = new Vuex.Store(
    storeData
)
window.Fire = new Vue();
//import v-form package
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
// end v-form
// for sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.Toast = Toast;
//end sweet alert

// editor support
import 'v-markdown-editor/dist/index.css';
import Editor from 'v-markdown-editor'
Vue.use(Editor);

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );

//moment js
import {filter} from './filter'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueTags from 'vue-tags'

Vue.component('input-tags', VueTags);
Vue.component('pagination', require('laravel-vue-pagination'));

import VueTagsInput from '@johmun/vue-tags-input';
Vue.component('vue-tags-input', VueTagsInput);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin-main', require('./components/admin/AdminMaster.vue').default);
Vue.component('home-main', require('./components/public/PublicMaster.vue').default);
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

import { routes } from './routes';

 const router = new VueRouter({
     routes, // short for `routes: routes`
     mode:'hash',
 })

const app = new Vue({
    el: '#app',
    router,
    store,
});
