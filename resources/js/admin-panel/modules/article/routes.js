import Article from './Article'
import Create from "../article/Create";
import Edit from "../article/Edit";
export default [{
    name: 'admin-panel.article',
    path: 'articles',
    component: Article,
}, {
    path: 'article/create',
    name: 'admin-panel.article.create',
    component: Create
}, {
    path: 'article/:id/edit',
    name: 'admin-panel.article.edit',
    component: Edit
}]
