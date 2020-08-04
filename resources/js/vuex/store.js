import Vue from 'vue';
import Vuex from 'vuex';
import sidebar from './modules/sidebar/store.js';
import loader from './modules/loader/store.js';


Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        sidebar: sidebar,
        loader: loader
    }
});
