import {routes as home} from './modules/home'
import {routes as article} from './modules/article'
import {routes as category} from './modules/category'
import {routes as comment} from './modules/comment'
import {routes as file} from './modules/file'
import {routes as system} from './modules/system'
import {routes as tag} from './modules/tag'
import {routes as user} from './modules/user'
import {routes as visitor} from './modules/visitor'
import Main from './Main';

export default [{
    path: '/' + window.Language + '/admin-panel',
    component: Main,
    beforeEnter: requireAuth,
    children: [
        ...home,
        ...article,
        ...category,
        ...comment,
        ...file,
        ...system,
        ...tag,
        ...user,
        ...visitor
    ],
}]

function requireAuth(to, from, next) {
    if (window.User) {
        return next()
    } else {
        return next('/')
    }
}
