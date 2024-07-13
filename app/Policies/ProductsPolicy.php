<?php

namespace App\Policies;

use App\Models\Products;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductsPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Products $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Products $product): bool
    {
        return $user->id === $product->user_id;
    }
}
