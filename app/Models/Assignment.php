<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';

    protected $fillable = [
        'id',
        'option1_id',
        'option2_id',
        'option3_id',
        'start',
        'end'
    ];

    function option1(){
        return $this->belongsTo(User::class, 'option1_id');
    }

    function option2(){
        return $this->belongsTo(User::class, 'option2_id');
    }

    function option3(){
        return $this->belongsTo(User::class, 'option3_id');
    }
}
