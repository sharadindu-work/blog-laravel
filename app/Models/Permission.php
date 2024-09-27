<?php

namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{
     protected $fillable = ['group_name', 'portal'];

}
