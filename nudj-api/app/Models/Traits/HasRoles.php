<?php

namespace App\Models\Traits;

trait HasRoles
{
    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }

    public function hasRole($role)
    {
        return in_array($role, json_decode($this->roles));
    }
}