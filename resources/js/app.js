/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// vue-router configuration
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
    { path: '/dashboard', component: require('./components/ExampleComponent.vue').default },
    { path: '/category', component: require('./components/Category.vue').default },
    { path: '/post', component: require('./components/Post.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    // blog vues
    { path: '/contact', component: require('./components/blog/Contact.vue').default },
    { path: '/index', component: require('./components/blog/Index.vue').default },
  ]

  const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
  })

  // v-form configuration
  import {Form,HasError,AlertError} from 'vform'
  window.Form=Form;
  // global component/ have access everywhere
  Vue.component(HasError.name,HasError)
  Vue.component(AlertError.name,AlertError)

  // global filter configuration
  Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1);
  });
  // vue-progressbar configuration
  import VueProgressBar from 'vue-progressbar';
  Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
  })
  // sweet alert configuration
  // ES6 Modules or TypeScript
  import Swal from 'sweetalert2'

  // CommonJS
  window.Swal = Swal;
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast;
  //custum event global event listener object
  let Fire= new Vue();
  window.Fire=Fire;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
  
    router
});
