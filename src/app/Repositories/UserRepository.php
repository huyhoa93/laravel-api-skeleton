<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository {

    /**
     * get model
     * @return User
     */
    public function getModel()
    {
        return User::class;
    }

    public function getUsers()
    {
        return $this->model->select('id', 'name', 'email')->get();
    }
}
