<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BaseModel as Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class Transaction extends BasePolicy
{
    use HandlesAuthorization;

    protected $model = 'transaction';

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Model $model)
    {
        return false;
    }

    public function delete(User $user, Model $model)
    {
        return false;
    }

    public function restore(User $user, Model $model)
    {
        return false;
    }

    public function forceDelete(User $user, Model $model)
    {
        return false;
    }
}
