<?php

namespace App\Models\Blog;

use App\Models\Traits\ImageServais;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable, ImageServais;

    const IMAGE_WATERMARK =    'img/logo/logo_vinograd.png';

    protected $table = 'vinograd_blog_category';
    public $timestamps = false;
    protected $fillable = ['name','title', 'slug', 'content', 'meta_key', 'meta_desc'];

//==================================
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //======== Relationships ================
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('name');
    }

    public function postsActive()
    {
        return $this->hasMany(Post::class)->orderBy('name')->active();
    }

    //========= scope ===================
    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    //======================================
    public static function add($fields)
    {
        $category = new static;
        $category->name = $fields['name'];
        $category->title = $fields['title'];
        $category->content = $fields['content'] ?: $fields['title'];
        $category->meta_key = $fields['meta_key'] ?: $fields['title'];
        $category->meta_desc = $fields['meta_desc'] ?: $fields['title'];

        $category->save();

        return $category;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

}
