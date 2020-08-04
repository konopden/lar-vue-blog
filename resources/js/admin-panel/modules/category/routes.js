import Category from './Category'
import Create from "../category/Create";
import Edit from "../category/Edit";
export default [{
    name: 'admin-panel.category',
    path: 'categories',
    component: Category,
}, {
    path: 'category/create',
    name: 'admin-panel.category.create',
    component: Create
}, {
    path: 'category/:id/edit',
    name: 'admin-panel.category.edit',
    component: Edit
}]
