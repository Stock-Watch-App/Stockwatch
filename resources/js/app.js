/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require("./bootstrap");
require("vue-flash-message/dist/vue-flash-message.min.css");
window.Vue = require("vue");

import VueFlashMessage from "vue-flash-message";

Vue.use(VueFlashMessage);

import SmartTable from "vuejs-smart-table";

Vue.use(SmartTable);

import Vue2TouchEvents from 'vue2-touch-events'

Vue.use(Vue2TouchEvents)

import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

// import { Line } from 'vue-chartjs'


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
    faSignOut,
    faMinus,
    faPlus,
    faUndoAlt,
    faEye,
    faSpinner,
    faInfoCircle,
    faChevronDown,
    faChevronRight,
    faChevronLeft,
    faMicrophone,
    faBug,
    faTrophy,
    faSignInAlt,
    faSignIn,
    faFileDownload,
    faFileUpload
} from "@fortawesome/pro-solid-svg-icons";
import {
    faTwitch,
    faTwitter,
    faDiscord,
    faFacebookF,
    faReddit
} from "@fortawesome/free-brands-svg-icons";

import {
    faArrowUp as faArrowUpDuo,
    faArrowDown as faArrowDownDuo,
    faChartLine,
    faTrophyAlt,
    faBinoculars,
    faChartNetwork,
    faArrowToLeft,
    faArrowToRight,
} from "@fortawesome/pro-duotone-svg-icons";

import { } from "@fortawesome/pro-light-svg-icons";

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
    faSignOut,
    faMinus,
    faPlus,
    faUndoAlt,
    faEye,
    faSpinner,
    faChartLine,
    faInfoCircle,
    faChevronDown,
    faChevronRight,
    faChevronLeft,
    faMicrophone,
    faBug,
    faTrophy,
    faTrophyAlt,
    faSignInAlt,
    faSignIn,
    faArrowUpDuo,
    faArrowDownDuo,
    faBinoculars,
    faChartNetwork,
    faArrowToLeft,
    faArrowToRight,
    faFileDownload,
    faFileUpload
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
    "houseguest-chart",
    require("./components/houseguest/HouseguestChart.vue").default
);

Vue.component(
    "line-chart",
    require("./components/LineChart.vue").default
);

Vue.component(
    "profile-panel",
    require("./components/profile/Panel.vue").default
);
Vue.component("avatar", require("./components/Avatar.vue").default);

Vue.component("select-component", require("./components/Select.vue").default);

Vue.component("icon-button", require("./components/IconButton.vue").default);

Vue.component("first-badge", require("./components/badges/First.vue").default);

Vue.component("second-badge", require("./components/badges/Second.vue").default);

Vue.component("third-badge", require("./components/badges/Third.vue").default);

Vue.component("topfive-badge", require("./components/badges/TopFive.vue").default);

Vue.component("topten-badge", require("./components/badges/TopTen.vue").default);

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
        isActive: true,
        isMobile: false,
        isLocal: process.env.MIX_LOCAL_ENV,
    },
    // extends: Line,
    mounted() {
        if (
            typeof window.orientation !== "undefined" ||
            navigator.userAgent.indexOf("IEMobile") !== -1
        ) {
            //then this is a mobile device
            this.isActive = false;
            this.isMobile = true;
        }
        // this.renderChart(this.chartdata, this.options)
    },
    methods: {
        toggleNavbar: function (event) {
            this.isActive = !this.isActive;
        },
        swipeHandler (direction) {
            this.isActive = !this.isActive;
        }
    },
    props: {
        loading: {
            default: false,
            type: Boolean
        }
        // chartdata: {
        //     type: Object,
        //     default: null
        // },
        // options: {
        //     type: Object,
        //     default: null
        // }
    }
});




// export default {
//     extends: Line,
//     props: {
//         chartdata: {
//             type: Object,
//             default: null
//         },
//         options: {
//             type: Object,
//             default: null
//         }
//     },
//     mounted() {
//         this.renderChart(this.chartdata, this.options)
//     }
// }
