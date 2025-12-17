<?php

namespace App\Policies;

use App\Models\Payhead;
use App\Models\SalaryScaleItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PayheadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payhead $payhead): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payhead $payhead): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payhead $payhead)
    {
        $has = SalaryScaleItem::query()->where('payhead_id', $payhead->id)->count();
        if ($has) {
            return Response::deny("can't remove becouse payhead use on salary items");
        }
        $has = SalaryScaleItem::query()->where('payhead_id', $payhead->id)->count();
        if ($has) {
            return Response::deny("can't remove becouse payhead use on salary setup items");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payhead $payhead): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payhead $payhead): bool
    {
        return false;
    }
}
