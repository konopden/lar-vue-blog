import Tag from './Tag'
import Create from "../Tag/Create";
import Edit from "../Tag/Edit";
export default [{
    name: 'admin-panel.tag',
    path: 'tag',
    component: Tag,
}, {
    path: 'tag/create',
    name: 'admin-panel.tag.create',
    component: Create
}, {
    path: 'tag/:id/edit',
    name: 'admin-panel.tag.edit',
    component: Edit
}]
