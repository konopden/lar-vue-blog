import Vue from 'vue'
import Router from 'vue-router';
import { routes as adminPanelRoutes } from '../';
import App from '../App.vue';
Vue.use(Router);

const AppRoute = {
    path: '/',
    component: App,
    children: [...adminPanelRoutes],
};

const routes = [AppRoute];

const router = new Router({
    routes,
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    mode: 'history',
});

export default router
