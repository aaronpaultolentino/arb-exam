<?php

namespace App;

use App\Traits\FormatsDate;
use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    //
    use FormatsDate;
    
    /**
     * @var array
     */
    protected $fillable = [
        'ip',
        'date',
        'time',
        'full_response',
    ];
}
