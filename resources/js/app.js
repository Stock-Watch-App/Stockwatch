/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import tailwind globally
import VueTailwind from 'vue-tailwind'
Vue.use(VueTailwind)

// font awesome icons
// not a huge fan of this global import situation, maybe this should be scoped to components (I tried and failed)
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faStar, faArrowUp } from '@fortawesome/free-solid-svg-icons'

library.add(faStar, faArrowUp)

Vue.component('font-awesome-icon', FontAwesomeIcon)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('stock-card', require('./components/StockCard.vue').default);

import StockCard from './components/StockCard.vue';
import StockCardList from './components/StockCardList.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    // local registration, I think?
    components: {
        StockCard,
        StockCardList
    }
});
