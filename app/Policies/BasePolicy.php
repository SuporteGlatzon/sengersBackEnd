<?php

namespace App\Policies;

use App\Models\Role;

class BasePolicy
{
    private $roleAdmin = [Role::ADMIN, Role::SUPERADMIN];

    public function create()
    {
        return in_array(request()->user()->role_id, $this->roleAdmin);
    }

    public function update()
    {
        return in_array(request()->user()->role_id, $this->roleAdmin);
    }

    public function delete()
    {
        return in_array(request()->user()->role_id, $this->roleAdmin);
    }

    public function forceDelete()
    {
        return request()->user()->canFullPermission();
    }

    public function restore()
    {
        return request()->user()->canFullPermission();
    }
}
