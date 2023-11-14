<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'assignment_details';

    protected $fillable = [
        'id',
        'assignment_id',
        'option1_id',
        'option2_id',
        'option3_id',
        'raffle_id',
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

    function raffle(){
        return $this->belongsTo(Raffle::class,);
    }
}
