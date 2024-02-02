<?php

namespace App\Models\Vinograd;

use App\Models\Traits\HasSlug;
use App\Models\Traits\ImageServais;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasSlug;
    use ImageServais;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    protected $table = 'vinograd_pages';
    public $timestamps = false;
    protected $fillable = ['title','name', 'slug', 'content', 'meta_desc', 'meta_key'];

    const IMAGE_WATERMARK = 'img/logo/watermark-vinograd-blog.png';

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    public static function add($fields)
    {
        $page = new static;
        $page->fill($fields->all());
        $page->save();
        self::setPage();

        return $page;
    }

    public function edit($fields)
    {
        $this->fill($fields->all());
        $this->save();
    }

    public function remove()
    {
        $this->delete();
        self::setPage();
    }

    public function setDraft()
    {
        $this->status = self::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = self::IS_PUBLIC;
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

    public static function moveUp($id)
    {
        $pages = self::orderBy('sort')->get();
        foreach ($pages as $i => $page) {
            if ($page->id == $id) {
                if ($pages->has($i - 1)) {
                    $prev = $pages[$i - 1];
                    $pages[$i - 1] = $page;
                    $pages[$i] = $prev;
                    self::setPage($pages);
                }
                return;
            }
        }
        throw new \DomainException('Такая страница не найдена.');
    }

    public static function moveDown($id)
    {
        $pages = self::orderBy('sort')->get();
        foreach ($pages as $i => $page) {
            if ($page->id == $id) {
                if ($pages->has($i + 1)) {
                    $next = $pages[$i + 1];
                    $pages[$i + 1] = $page;
                    $pages[$i] = $next;
                    self::setPage($pages);
                }
                return;
            }
        }
        throw new \DomainException('Такая страница не найдена.');
    }

    private static function setPage($collect = false)
    {
        $pages = $collect ?: Page::orderBy('sort')->get();
        $i = 1;
        foreach ($pages as $page) {
            $page->sort = $i;
            $page->save();
            $i++;
        }
        return;
    }
}
