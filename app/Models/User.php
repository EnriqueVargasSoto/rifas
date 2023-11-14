<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'dni',
        'short_name',
        'phone',
        'unit',
        'area',
        'position',
        'email',
        'password',
        'clave',
        'observation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function role(){
        return $this->belongsTo(Role::class);
    }

    public function scopeSearch($query,$term){
        if($term){
            return $query->orWhere('name','like','%'.$term.'%')
            ->orWhere('dni','like','%'.$term.'%')
            ->orWhere('short_name','like','%'.$term.'%')
            ->orWhere('phone','like','%'.$term.'%')
            ->orWhere('unit','like','%'.$term.'%')
            ->orWhere('area','like','%'.$term.'%');
        }

        return $query;
    }
}
