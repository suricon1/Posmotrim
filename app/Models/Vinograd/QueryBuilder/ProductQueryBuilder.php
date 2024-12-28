<?php

namespace App\Models\Vinograd\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function getFilteredProducts()
    {
        return $this->active()
            ->with('modifications.property', 'selection:id,name,slug', 'country:id,name,slug')
            ->where(function (Builder $query) {
                    $query->filtered();
                })
            ->paginate(30)
            ->withQueryString();
    }
}
