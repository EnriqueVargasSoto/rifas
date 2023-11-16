<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangeStatusRequest extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function userGestion()
    {
        return $this->belongsTo(User::class, 'user_id_gestion', 'id');
    }

    public function changeStatusRaffles()
    {
        return $this->hasMany(ChangeStatusRaffles::class, 'change_status_request_id', 'id');
    }

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
