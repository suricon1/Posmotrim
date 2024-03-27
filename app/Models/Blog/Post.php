<?php

namespace App\Models\Blog;

use App\Models\Meta;
use App\Models\Site\User;
use App\Models\Traits\GalleryServais;
use App\Models\Traits\HasSlug;
use App\Models\Traits\ImageServais;
use App\Models\Vinograd\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{
    use ImageServais;
    use GalleryServais;
    use HasSlug;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    const IMAGE_WATERMARK =    'img/logo/watermark-vinograd-blog.png';

    public $imageList = [
        '220x165',   //
        '660x495',   // для страниц секций
        '900x'       // для страницы поста
    ];

    protected $table = 'vinograd_posts';
    public $timestamps = false;
    protected $fillable = ['name', 'content', 'description', 'slug', 'category_id'];

    protected $casts = [
        'meta' => 'array',
    ];

//==================================

//======== Relationships ================
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categoryActive()
    {
        return $this->belongsTo(Category::class)->active();
    }

//    public function tags()
//    {
//        return $this->belongsToMany(
//            Tag::class,
//            'post_tags',
//            'post_id',
//            'tag_id'
//        );
//    }


//======== Scopes ===================
    public function scopeActive($query)
    {
        return $query->where('status', 0);

    }

    public function scopeSort($query, $sort = false)
    {
        return $sort
            ? $query->orderBy($sort['field'], $sort['order_by'])
            : $query->orderBy('id', 'desc');
    }

//============ Actions ===========================
    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields->all());
        $post->author()->associate(Auth::user());
        $post->date_add = time();
        $post->date_edit = time();
        $post->meta = new Meta($fields, $fields['name']);
        $post->save();

        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields->all());
        $this->date_edit = time();
        $this->meta = new Meta($fields, $fields['name']);
        $this->save();
    }

    public function remove()
    {
        $this->deleteImages();
        $this->delete();
    }
//============ End Actions ===========================

    public static function getPostForHome()
    {
        return cache()->remember('posts_home', 24*60, function () {
            return self::select('id', 'slug', 'name', 'date_add')
                ->orderByDesc('view')
                ->active()
                ->take(6)
                ->get();
        });
    }

    public function setTags($ids)
    {
        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        return ($value == null) ? $this->setDraft() : $this->setPublic();
    }

    public function toggledsStatus()
    {
        return ($this->status == 0) ? $this->setPublic() : $this->setDraft();
    }

    public function setFeatured()
    {
        $this->featured = 1;
        $this->save();
    }

    public function setStandart()
    {
        $this->featured = 0;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        return($value == null) ? $this->setStandart() : $this->setFeatured();
    }

    public function StrLimit($str, $limit)
    {
        return STR::limit(wp_strip_all_tags(htmlspecialchars_decode($str)), $limit);
    }

    public function classNameByIDForCache()
    {
        return 'contents-'.strtolower(class_basename(self::class)).'-'.$this->id;
    }
}
