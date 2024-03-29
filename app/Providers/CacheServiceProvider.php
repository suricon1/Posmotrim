<?php

namespace App\Providers;

use App\Jobs\SitemapVinograd;
use App\Models\Vinograd\Category;
use App\Models\Vinograd\Country;
use App\Models\Vinograd\Modification;
use App\Models\Vinograd\Product;
use App\Models\Vinograd\Selection;
use App\Models\Vinograd\Slider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->productEvent ();
        $this->modificationEvent ();
        $this->categoryEvent ();
        $this->sliderEvent ();
    }

    private function productEvent ()
    {
        $func = function() {
            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');
            cache()->delete('priceListHTML');
            cache()->delete('categorys_category');
            cache()->delete('categorys_selection');
            cache()->delete('categorys_country');
            cache()->forget('home_page');
        };

        Product::created($func);
        Product::updated($func);
        Product::deleted($func);
    }

    private function modificationEvent ()
    {
        $func = function() {
            cache()->delete('priceListHTML');
        };

        Modification::created($func);
        Modification::updated($func);
        Modification::deleted($func);
    }

    private function categoryEvent ()
    {
        $func = function() {
            dispatch(new SitemapVinograd());
            cache()->delete('siteMapHTML');
            cache()->delete('categorys_category');
            cache()->delete('categorys_selection');
            cache()->delete('categorys_country');
            cache()->forget('home_page');
            cache()->forget('all_categories');
        };

        Category::created($func);
        Category::updated($func);
        Category::deleted($func);

        Country::created($func);
        Country::updated($func);
        Country::deleted($func);

        Selection::created($func);
        Selection::updated($func);
        Selection::deleted($func);
    }

    private function sliderEvent ()
    {
        $func = function() {
            cache()->delete('slider');
        };

        Slider::created($func);
        Slider::updated($func);
        Slider::deleted($func);
    }
}
