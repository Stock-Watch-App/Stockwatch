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
import { faStar, faArrowUp, faBars, faColumns, faAward, faHistory, faUserCircle, faUserShield, faSignOutAlt, faMinus, faPlus } from '@fortawesome/free-solid-svg-icons'
import { faTwitch, faTwitter, faDiscord, faFacebookF, faReddit } from '@fortawesome/free-brands-svg-icons'

library.add(faStar, faArrowUp, faBars, faColumns, faTwitch, faTwitter, faDiscord, faFacebookF, faReddit, faAward, faHistory, faUserCircle, faUserShield, faSignOutAlt, faMinus, faPlus)

Vue.component('font-awesome-icon', FontAwesomeIcon)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('slideout-nav', require('./components/SlideoutNav.vue').default);
Vue.component('stock-card', require('./components/dashboard/StockCard.vue').default);
Vue.component('dashboard-panel', require('./components/dashboard/Panel.vue').default);


// import StockCard from './components/StockCard.vue';
// import StockCardList from './components/StockCardList.vue';
// import Slideout from 'vue-slideout'


//=== FILTERS ===//
Vue.filter('capitalize', require('./filters/Capitalize.js').default);
Vue.filter('currency', require('./filters/Currency.js').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        isActive: true
    },
    mounted() {
      if ((typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1)) {
          //then this is a mobile device
          this.isActive = false;
      }
    },
    methods: {
        toggleNavbar: function(event){
           this.isActive = !this.isActive;
        }
    }
});

