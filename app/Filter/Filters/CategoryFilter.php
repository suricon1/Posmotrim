<?php

namespace App\Filter\Filters;

use App\Filter\AbstractFilter;
use App\Models\Vinograd\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CategoryFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Назначение';
    }

    public function key(): string
    {
        return 'category';
    }

    public function apply(Builder $query): Builder
    {
        return $query;
    }

    public function values(): array
    {
        return ProductRepository::getAllCategorysOfCountProducts();
    }

    public function view(): string
    {
        return 'vinograd.filters.categories';
    }
}
