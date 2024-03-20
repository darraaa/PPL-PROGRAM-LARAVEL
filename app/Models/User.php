<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'username',
        'password',
        'name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship with Address
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Relationship with Contact
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
