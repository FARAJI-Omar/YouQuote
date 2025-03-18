<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuotePolicy
{
    /**
    * Determine if the given quote can be updated by the user.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Quote  $quote
    * @return bool
    */

    public function update(User $user, Quote $quote)
    {
        return $user->id === $quote->user_id;
    }

    public function delete(User $user, Quote $quote)
    {
        return $user->id === $quote->user_id;
    }

    // public function viewAny(User $user): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Quote $quote): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Quote $quote): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Quote $quote): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Quote $quote): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Quote $quote): bool
    // {
    //     return false;
    // }
}
