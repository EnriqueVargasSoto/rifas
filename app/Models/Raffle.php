<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;

    protected $table = 'raffles';

    protected $fillable = [
        'id',
        'number',
        'code',
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


    public function raffleImages(){
        return $this->hasMany(RaffleImage::class, 'raffle_id', 'id');
    }

    public function scopeByStatus($query, $status = null)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeBySelected($query, $selected)
    {
        if ($selected) {
            return $query->where('selected', $selected);
        }
        return $query;
    }

    public function scopeByIsActive($query, $is_active)
    {
        if ($is_active) {
            return $query->where('is_active', $is_active);
        }
        return $query;
    }

    public function scopeByUser($query, $user_id)
    {
        if ($user_id) {
            return $query->where('user_id', $user_id);
        }
        return $query;
    }

    public function scopeBySearch($query, $search)
    {
        if ($search) {
            return $query->where('number', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%");
        }
        return $query;
    }

    public function scopeBetweenNumber($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('number', [$start, $end]);
        }
        return $query;
    }


    public function scopeByIsVisibleInWeb($query, $is_visible_in_web=null)
    {
        if ($is_visible_in_web!=null && in_array($is_visible_in_web, [0,1])) {
            return $query->where('is_visible_in_web', $is_visible_in_web);
        }
        return $query;
    }

    public function scopeByFirstUser($query, $user_id_1=null)
    {
        if ($user_id_1) {
            return $query->where('user_id_1', $user_id_1);
        }
        return $query;
    }

    public function scopeBySecondUser($query, $user_id_2=null)
    {
        if ($user_id_2) {
            return $query->where('user_id_2', $user_id_2);
        }
        return $query;
    }

    public function scopeByThirdUser($query, $user_id_3=null)
    {
        if ($user_id_3) {
            return $query->where('user_id_3', $user_id_3);
        }
        return $query;
    }


}
