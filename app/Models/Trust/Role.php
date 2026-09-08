<?php

namespace App\Models\Trust;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'roles';
}
