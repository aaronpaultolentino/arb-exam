<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    const ADMIN_ROLE_ID = 1;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
