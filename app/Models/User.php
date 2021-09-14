<?php

namespace App\Models;

use DateTimeInterface;
use Faker\Generator as Faker;
use Faker\Provider\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'phone_number',
        'avatar',
        'admin',
        'email_verified_at',
        'introduction'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, "user_id", "id");
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, "followers", "user_id", "follower_id");
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, "followers", "follower_id", "user_id");
    }





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
            $user->nickname = $user->nickname ?? "用户_" . $faker->uuid();
            $user->password  =  $user->password ?? "123456";
            $user->email  =  $user->email ??  $faker->uuid() . "@null.null";
            // $user->save();
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
