<?php

namespace App\Transformers;

use App\Visitor;
use League\Fractal\TransformerAbstract;

class VisitorTransformer extends TransformerAbstract
{
    public function transform(Visitor $visitor)
    {
        return [
            'id' => $visitor->id,
            'article' => isset($visitor->article) ? $visitor->article->title : 'null',
            'ip' => $visitor->ip . ' ' . $visitor->country,
            'views' => $visitor->views
        ];
    }
}
