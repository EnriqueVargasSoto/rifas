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

    public function scopeByVisibilityWeb($query, $visibility_web)
    {
        if (in_array($visibility_web, [0, 1])) {
            return $query->where('is_visible_in_web', $visibility_web);
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
}
