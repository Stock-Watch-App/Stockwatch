<?php

namespace App\Policies;

use App\Models\BaseModel as Model;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected $model;

    public function viewAny(User $user)
    {
        if ($user->can("view {$this->model}")) {
            return true;
        }
    }

    public function view(?User $user, Model $model)
    {
        if ($user->can("view {$this->model}")) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->can("create {$this->model}")) {
            return true;
        }
    }

    public function update(User $user, Model $model)
    {
        if ($user->can("update {$this->model}")) {
            return true;
        }
    }

    public function delete(User $user, Model $model)
    {
        if ($user->can("delete {$this->model}")) {
            return true;
        }
    }

    public function restore(User $user, Model $model)
    {
        if ($user->can("restore {$this->model}")) {
            return true;
        }
    }

    public function forceDelete(User $user, Model $model)
    {
        if ($user->can("force delete {$this->model}")) {
            return true;
        }
    }
}
