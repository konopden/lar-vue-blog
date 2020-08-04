import User from './User'
import Create from './Create'
import Edit from './Edit'
import App from '../../App.vue';
export default [{
    path: 'users',
    component: App,
    children: [{
        path: '/',
        name: 'admin-panel.user',
        component: User
    }, {
        path: 'create',
        name: 'admin-panel.user.create',
        component: Create
    }, {
        path: ':id/edit',
        name: 'admin-panel.user.edit',
        component: Edit
    }]
}]
