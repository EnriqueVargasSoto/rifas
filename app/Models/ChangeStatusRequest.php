<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeStatusRequest extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUserId($query, $userId=null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }

        return $query;
    }



    public function scopeByCreatedDate($query, $date=null)
    {
        if ($date) {
            return $query->whereDate('created_at', $date);
        }
        return $query;
    }


}
