<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $vote = User::class;

    protected $fillable = [
        'user_id', 'article_id', 'content', 'status'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user for the discussion comment.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning parent_id models.
     *
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Set the content Attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = htmlspecialchars($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return date("F d, Y H:i", strtotime($value));
    }

}
