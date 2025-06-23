<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HauraUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'haura_users';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = ['password'];

    // Relasi: satu user bisa punya banyak booking
    public function bookings()
    {
        return $this->hasMany(HauraBooking::class, 'user_id');
    }
}