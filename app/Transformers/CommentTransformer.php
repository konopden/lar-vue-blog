<?php

namespace App\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'username' => isset($comment->user) ? $comment->user->name : '',
            'article_title' => isset($comment->article) ? $comment->article->title : '',
            'status' => $comment->status,
            'created_at' => $comment->created_at,
        ];
    }
}
