<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;


class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    protected $table = 'clients';

    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('name', 'like', '%' . $term . '%')
                ->orWhere('last_name', 'like', '%' . $term . '%')
                ->orWhere('email', 'like', '%' . $term . '%')
                ->orWhere('phone', 'like', '%' . $term . '%');
        }
        return $query;
    }

    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->password);
    }
}
