<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vkontakte_id',
        'vkontakte_logged_in_at',
        'vkontakte_registered_at',
        'google_id',
        'google_logged_in_at',
        'google_registered_at',
        'app_logged_in_at',
        'app_registered_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'vkontakte_id',
        'google_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'vkontakte_logged_in_at' => 'datetime',
        'vkontakte_registered_at' => 'datetime',
        'google_logged_in_at'=> 'datetime',
        'google_registered_at'=> 'datetime',
        'app_logged_in_at'=> 'datetime',
        'app_registered_at'=> 'datetime',
    ];

    public static function createFromRequest(array $data) : User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->app_logged_in_at = Carbon::now();
        $user->app_registered_at = Carbon::now();
        $user->save();

        return $user;
    }
}
