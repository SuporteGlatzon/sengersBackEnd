<?php

namespace App\Policies;

class AuditPolicy extends BasePolicy
{

    public function view()
    {
        return request()->user()->canFullPermission();
    }

    public function viewAny()
    {
        return request()->user()->canFullPermission();
    }

    public function create()
    {
        return request()->user()->canFullPermission();
    }

    public function update()
    {
        return request()->user()->canFullPermission();
    }

    public function delete()
    {
        return request()->user()->canFullPermission();
    }
}
