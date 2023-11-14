<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'assignments';

    protected $fillable = [
        'id',
        'option1_id',
        'option2_id',
        'option3_id',
        'start',
        'end'
    ];

    public function firstUser()
    {
        return $this->belongsTo(User::class, 'user_id_1', 'id');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class, 'user_id_2', 'id');
    }

    public function thirdUser()
    {
        return $this->belongsTo(User::class, 'user_id_3', 'id');
    }

}
