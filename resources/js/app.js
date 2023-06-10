require("./bootstrap");

window.Vue = require("vue").default;
import PortalVue from "portal-vue";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.component("bell-component", require("./views/bell.vue").default);
Vue.component(
    "civil_service-component",
    require("./views/users/pds/civil_service.vue").default
);

// hr
Vue.component("dashboard-employee",require("./views/hr/employees.vue").default);
Vue.component("dashboard-leave", require("./views/hr/leave/leave.vue").default);
Vue.component("hr-leave_app",require("./views/hr/leave_application.vue").default);
Vue.component("hr-service_record",require("./views/hr/service_record.vue").default);
Vue.component("hr-plantilla",require("./views/hr/plantilla.vue").default);
Vue.component("hr-publication",require("./views/hr/publication.vue").default);
Vue.component("hr-department",require("./views/hr/department.vue").default);

// R n R
Vue.component("hr-loyalty-reward",require("./views/hr/RnR/loyalty.vue").default);

// rsp
Vue.component("hr-applicant",require("./views/hr/rsp/applicant.vue").default);
Vue.component("hr-ranking",require("./views/hr/rsp/ranking.vue").default);
Vue.component("hr-accepted",require("./views/hr/rsp/accepted.vue").default);

// pms

Vue.component("hr-pms-emp",require("./views/hr/pms/employees.vue").default);
Vue.component("hr-pms-dep",require("./views/hr/pms/department.vue").default);

// print
Vue.component("hr-print-index",require("./views/hr/print/index.vue").default);

import JwPagination from "jw-vue-pagination";
Vue.component("jw-pagination", JwPagination);
// alert
Vue.component("flash", require("./components/Flash.vue"));
Vue.component('app-alert', require('./components/alert/Notifier.vue').default);

// data table
import DataTable from "laravel-vue-datatable";
Vue.use(DataTable);

import vuetify from "../js/vuetify"; // path to vuetify export
// const app = new Vue({
//     el: '#app',
// });

import moment from "moment";
Vue.filter("formatDate", function (value) {
    if (value) {
        return moment(String(value)).format("YYYY-MM-DD");
    }
});

new Vue({
    vuetify,
}).$mount("#app");
