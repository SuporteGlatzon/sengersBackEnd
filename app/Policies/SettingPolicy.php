<?php

namespace App\Policies;

class SettingPolicy extends BasePolicy
{

    public function create()
    {
        return false;
    }

    public function delete()
    {
        return false;
    }
}
