<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RaffleImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'raffle_images';

    // TODO CREATE custom property to get the image url

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }


}
