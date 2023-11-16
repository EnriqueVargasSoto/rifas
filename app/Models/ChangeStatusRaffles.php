<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeStatusRaffles extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}
