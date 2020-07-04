/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require("vue-flash-message/dist/vue-flash-message.min.css");
window.Vue = require("vue");

// import tailwind globally
import VueTailwind from "vue-tailwind";

Vue.use(VueTailwind);

import VueFlashMessage from "vue-flash-message";

Vue.use(VueFlashMessage);

import SmartTable from "vuejs-smart-table";

Vue.use(SmartTable);

// font awesome icons
// not a huge fan of this global import situation, maybe this should be scoped to components (I tried and failed)
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faStar,
    faArrowUp,
    faArrowDown,
    faBars,
    faColumns,
    faAward,
    faHistory,
    faUserCircle,
    faUserShield,
    faSignOutAlt,
    faMinus,
    faPlus,
    faUndoAlt,
    faEye,
    faSpinner,
    faChartLine,
    faInfoCircle,
    faChevronDown,
    faMicrophone,
    faBug,
    faTrophy,
    faSignInAlt
} from "@fortawesome/free-solid-svg-icons";
import {
    faTwitch,
    faTwitter,
    faDiscord,
    faFacebookF,
    faReddit
} from "@fortawesome/free-brands-svg-icons";

library.add(
    faStar,
    faArrowUp,
    faArrowDown,
    faBars,
    faColumns,
    faTwitch,
    faTwitter,
    faDiscord,
    faFacebookF,
    faReddit,
    faAward,
    faHistory,
    faUserCircle,
    faUserShield,
    faSignOutAlt,
    faMinus,
    faPlus,
    faUndoAlt,
    faEye,
    faSpinner,
    faChartLine,
    faInfoCircle,
    faChevronDown,
    faMicrophone,
    faBug,
    faTrophy,
    faSignInAlt
);

Vue.component("font-awesome-icon", FontAwesomeIcon);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

Vue.component(
    "stock-card",
    require("./components/trades/StockCard.vue").default
);
Vue.component("trade-panel", require("./components/trades/Panel.vue").default);
Vue.component(
    "guest-trade-panel",
    require("./components/trades/Guest.vue").default
);
Vue.component(
    "dashboard-panel",
    require("./components/dashboard/Panel.vue").default
);
Vue.component(
    "holdings-card",
    require("./components/dashboard/HoldingsCard.vue").default
);

Vue.component(
    "projection-item",
    require("./components/projections/ProjectionItem.vue").default
);

Vue.component(
    "leaderboard-table",
    require("./components/leaderboard/LeaderboardTable.vue").default
);
Vue.component(
    "all-leaderboard-table",
    require("./components/leaderboard/AllLeaderboardTable.vue").default
);
Vue.component(
    "profile-panel",
    require("./components/profile/Panel.vue").default
);

// import StockCard from './components/StockCard.vue';
// import StockCardList from './components/StockCardList.vue';
// import Slideout from 'vue-slideout'

//=== FILTERS ===//
Vue.filter("capitalize", require("./filters/Capitalize.js").default);
Vue.filter("currency", require("./filters/Currency.js").default);
Vue.filter("date", require("./filters/Date.js").default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.devtools = true;

const app = new Vue({
    el: "#app",
    data: {
        isActive: true
    },
    mounted() {
        if (
            typeof window.orientation !== "undefined" ||
            navigator.userAgent.indexOf("IEMobile") !== -1
        ) {
            //then this is a mobile device
            this.isActive = false;
        }
    },
    methods: {
        toggleNavbar: function(event) {
            this.isActive = !this.isActive;
        }
    }
});
