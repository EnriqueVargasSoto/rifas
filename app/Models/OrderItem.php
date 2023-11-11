<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='order_items';

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function raffle(){
        return $this->belongsTo(Raffle::class,'raffle_id','id');
    }
}
