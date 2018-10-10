<?php

namespace Dot\Seo\Models;

use Dot\Media\Models\Media;
use Dot\Pages\Models\Page;
use Dot\Platform\Model;
use Dot\Posts\Models\Post;

class SEO extends Model
{

    public $timestamps = false;
    protected $table = 'seo';
    protected $fillable = [];
    protected $guarded = ['id'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'post_id');
    }

    public function facebook()
    {
        return $this->hasOne(Media::class, 'id', 'facebook_image');
    }

    public function twitter()
    {
        return $this->hasOne(Media::class, 'id', 'twitter_image');
    }

}
