<?php

namespace App\Policies;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    public function admin_Show(User $user): bool
    {
        return $user->can('is-admin');
    }
}
