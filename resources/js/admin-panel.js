require('./bootstrap');

import router from './admin-panel/router'
import VueI18n from 'vue-i18n';
import lang from './admin-panel/lang';
import App from './admin-panel/App.vue';
import store from './vuex/store.js';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import 'simplemde/dist/simplemde.min.css';

window.toastr.options = {
    positionClass: "toast-top-center",
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    toastClass: 'toastr'
};
Vue.component(
    'vueTable',
    require('./admin-panel/components/Table.vue').default
);
Vue.component(
    'vueForm',
    require('./admin-panel/components/Form.vue').default
);
Vue.use(VueI18n);
Vue.config.lang = window.Language;
const i18n = new VueI18n({
    locale: Vue.config.lang,
    messages: lang,
    pluralizationRules: {
        'ru': function(choice, choicesLength) {
            if (choice === 0) {
                return 0;
            }
            const teen = choice > 10 && choice < 20;
            const endsWithOne = choice % 10 === 1;
            if (choicesLength < 4) {
                return (!teen && endsWithOne) ? 1 : 2;
            }
            if (!teen && endsWithOne) {
                return 1;
            }
            if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
                return 2;
            }
            return (choicesLength < 4) ? 2 : 3;
        }
    }
});
new Vue({
    router,
    store,
    i18n,
    render: (h) => h(App)
}).$mount('#app');
