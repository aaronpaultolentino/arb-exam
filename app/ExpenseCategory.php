<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    //
    protected $fillable = [
    	'name',
		'description',
		'created_by'
    ];

    /**
     * @return mixed
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
