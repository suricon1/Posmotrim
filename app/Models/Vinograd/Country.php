<?php

namespace App\Models\Vinograd;

class Country extends Category
{
    const TITLE = 'Страна происхождения';

    protected $table = 'vinograd_countrys';

    public function getCategoryFieldAttribute()
    {
        return 'country';
    }
}
