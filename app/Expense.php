<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //
    protected $fillable = [
    	'expense_category_id',
		'amount',
		'entry_date',
		'created_by',
    ];

    public function expense_category()
    {
    	return $this->belongsTo(ExpenseCategory::class);
    }
}
