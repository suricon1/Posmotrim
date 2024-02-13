<?php

namespace App\Filter\Filters;

use App\Filter\AbstractFilter;
use App\Models\Vinograd\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SelectionFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Селекционеры';
    }

    public function key(): string
    {
        return 'selection';
    }

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->requestValue(), function (Builder $q) {
                $q->orWhere(function (Builder $query) {
                    $query->whereIn('selection_id', $this->requestValue());
                });
        });
    }

    public function values(): array
    {
        return cache()->remember('categorys_selection', 30*24*60, function () {
            return Product::leftJoin('vinograd_selections AS selection', function ($join) {
                        $join->on('vinograd_products.selection_id', '=', 'selection.id');
                    })
                ->selectRaw('selection.id, selection.name, selection.slug, COUNT(`vinograd_products`.`id`) AS `count`')
                ->where('vinograd_products.status', 0)
                ->groupBy('selection.name', 'selection.id', 'selection.slug')
                ->get()
                ->toArray();
        });
    }

    public function view(): string
    {
        return 'vinograd.filters.selections';
    }
}
