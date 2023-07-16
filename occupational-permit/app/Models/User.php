<?php

namespace App\Models;

use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasRole;
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'password',
        'email',
        'is_new',
        'first_name',
        'last_name',
        'middle_name',
        'extension_name',
        'address',
        'contact_no',
        'position',
        'work_place'
    ];


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
    ];
}
