<?php

namespace App\Models\Vinograd\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

class OrderQueryBuilder extends Builder
{

    public function getAllUserOrders($user_id)
    {
        return $this->where('user_id', $user_id)
            ->orderBy('current_status')
            ->paginate(30);
    }
}
