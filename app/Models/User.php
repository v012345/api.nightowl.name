<?php

namespace App\Models;

use DateTimeInterface;
use Faker\Generator as Faker;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        // 'email',
        // 'password',
        // 'phone_number',
        'avatar',
        // 'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email_verified_at', 'country_code',
        // 'remember_token',
        'verifying_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * serialize date for array / JSON 
     * but I overwirte the method 
     * because the time than model return before is less 8 hours than now
     * I need East 8 not UTC
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * boot() will execute before new Model()
     * in it , I use a Listener (whichever) to listen the creating evnet
     * that will emit before Model::create() or $model->save()
     * @return void
     */
    public static function boot()
    {
        // static $count = 0;
        parent::boot();
        // static::creating(function ($user) use ($count) {
        static::creating(function ($user) {

            // ++$count;
            // if ($count > 5) {
            //     dump($count);
            //     exit;
            // }
            $faker = app(Faker::class);
            $user->name = $user->name ?? $faker->name();
            $user->phone_number  =  $user->phone_number ?? $faker->unique()->phoneNumber();
            $user->password  =  $user->password ?? $faker->password();
            // $user->save();
        });
    }
}
