<?php

namespace App\Policies;

use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class User
{
    use HandlesAuthorization;

    protected $model = 'user';

    public function viewAny(UserModel $user)
    {
        if ($user->can("view {$this->model}")) {
            return true;
        }
    }

    public function view(?UserModel $user, UserModel $model)
    {
        if ($user->can("view {$this->model}")) {
            return true;
        }
    }

    public function create(UserModel $user)
    {
        if ($user->can("create {$this->model}")) {
            return true;
        }
    }

    public function update(UserModel $user, UserModel $model)
    {
        if ($user->can("update {$this->model}")) {
            return true;
        }
    }

    public function delete(UserModel $user, UserModel $model)
    {
        if ($user->can("delete {$this->model}")) {
            return true;
        }
    }

    public function restore(UserModel $user, UserModel $model)
    {
        if ($user->can("restore {$this->model}")) {
            return true;
        }
    }

    public function forceDelete(UserModel $user, UserModel $model)
    {
        if ($user->can("force delete {$this->model}")) {
            return true;
        }
    }
}
