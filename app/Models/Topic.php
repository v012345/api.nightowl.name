<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'excerpt',
        'slug'
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function replies(){
        return $this->hasMany(Reply::class,"topic_id","id");
    }

    public function scopeOrderWith($query, $order)
    {
        switch ($order) {
            case 'updated_at':
                return  $query->updateAt();
            default:
                return  $query->createdAt();
        }
    }

    public function scopeUpdateAt($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeCreatedAt($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
