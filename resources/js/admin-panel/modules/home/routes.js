import Home from './Home';
export default [{
    path: '/',
    redirect: { name: 'admin-panel.home' },
}, {
    name: 'admin-panel.home',
    path: 'home',
    component: Home,
}]
