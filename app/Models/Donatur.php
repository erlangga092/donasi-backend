<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Donatur extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!empty($value)) {
                    return asset('storage/users/' . $value);
                } else {
                    return 'https://ui-avatars.com/api?name=' . str_replace(' ', '+', $this->name) . '&background=4e73df&color=ffffff&size=100';
                }
            }
        );
    }
}
