<?php

namespace App\Filter\Filters;

use App\Filter\AbstractFilter;
use App\Models\Vinograd\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CountryFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Страны';
    }

    public function key(): string
    {
        return 'country';
    }

    public function apply(Builder $query): Builder
    {
        return
        $query->when($this->requestValue(), function (Builder $q) {
            $q->orWhere(function (Builder $query) {
                $query->whereIn('country_id', $this->requestValue());
            });
        });
    }

    public function values(): array
    {
        return cache()->remember('categorys_country', 30*24*60, function () {
            return Product::leftJoin('vinograd_countrys AS country', function ($join) {
                    $join->on('vinograd_products.country_id', '=', 'country.id');
                })
                ->selectRaw('country.id, country.name, country.slug, COUNT(`vinograd_products`.`id`) AS `count`')
                ->where('vinograd_products.status', 0)
                ->groupBy('country.name', 'country.id', 'country.slug')
                ->get()
                ->toArray();
        });
    }

    public function view(): string
    {
        return 'vinograd.filters.selections';
    }
}
