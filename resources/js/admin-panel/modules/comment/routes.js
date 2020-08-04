import Comment from './Comment'
import Edit from "../Comment/Edit";

export default [
    {
        name: 'admin-panel.comment',
        path: 'comment',
        component: Comment,
    },
    {
        path: 'comment/:id/edit',
        name: 'admin-panel.comment.edit',
        component: Edit
    }
]
