<?php

namespace App\Models\Contracts;

interface HasRolesContract {

    public function isSuperAdmin();

    public function hasRole($role);

}