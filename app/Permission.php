<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = [
    	'name',
    	'role_id',
    	'action',
    ];

    public function role()
    {
    	return $this->belongsTo(Role::class);
    }
}
