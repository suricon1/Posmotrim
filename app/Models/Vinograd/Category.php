<?php

namespace App\Models\Vinograd;

use App\Models\Traits\HasSlug;
use App\Models\Traits\ImageServais;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    use HasSlug;
    use ImageServais;

    const DIR_CONTENT_IMAGE_NAME = 'content';
    const IMAGE_WATERMARK =    'img/logo/logo_vinograd.png';

    const ULTRA_EARLY = 1;
    const VERY_EARLY = 2;
    const EARLY = 3;
    const MEDIUM_EARLY = 4;
    const MEDIUM = 5;
    const MEDIUM_LATE = 6;

    const TITLE = 'Назначение и тип.';

    public $watermark = 'img/logo/logo_vinograd.png';

    protected $table = 'vinograd_categorys';
    public $timestamps = false;
    protected $fillable = ['name','title', 'slug', 'content', 'meta_key', 'meta_desc'];
    protected $appends = ['category_field'];

    public static $sortProductList = [
        'наличию &#8593;' => [
            'existenceDesc' => ['existence' => 'desc']
        ],
        'наличию &#8595;' => [
            'existenceAsc' => ['existence' => 'asc']
        ],
        'названию А - Я' => [
            'nameAsc' => ['name' => 'asc']
        ],
        'названию Я - А' => [
            'nameDesc' => ['name' => 'desc']
        ]
    ];

    public static $sortRipeningProducts = [
        self::ULTRA_EARLY => 'сверх-ранний ',
        self::VERY_EARLY => 'очень-ранний ',
        self::EARLY => 'ранний ',
        self::MEDIUM_EARLY => 'ранние-средний ',
        self::MEDIUM => 'средний ',
        self::MEDIUM_LATE => 'средне-поздний '
    ];

    public static $ripeningDays = [
        self::ULTRA_EARLY => '95 - 105',
        self::VERY_EARLY => '105 - 115',
        self::EARLY => '115 - 120',
        self::MEDIUM_EARLY => '120 - 125',
        self::MEDIUM => '125 - 135',
        self::MEDIUM_LATE => '135 - 140'
    ];

    public function getCategoryFieldAttribute()
    {
        return 'category';
    }

    public static function getRipeningName($key)
    {
        return self::$sortRipeningProducts[$key] . self::$ripeningDays[$key];
    }

    public static function getRipeningDays($key)
    {
        return self::$ripeningDays[$key];
    }

    public static function getSortArr()
    {
        $arr = [];
        foreach (self::$sortProductList as $value => $key){
            $arr[key($key)] = $value;
        }
        return $arr;
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('name');
    }

    public function productsActive()
    {
        return $this->hasMany(Product::class)->orderBy('name')->active();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    public static function add($fields)
    {
        $category = new static;
        $category->name = $fields['name'];
        $category->title = $fields['title'];
        $category->content = $fields['content'] ?: $fields['title'];
        $category->meta_key = $fields['meta_key'] ?: $fields['title'];
        $category->meta_desc = $fields['meta_desc'] ?: $fields['title'];
        $category->date_add = time();
        $category->date_edit = time();

        $category->save();
        return $category;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->date_edit = time();
        $this->save();
    }
}
