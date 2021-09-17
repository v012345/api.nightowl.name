<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content', "user_id", "topic_id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, "topic_id", "id");
    }

    public function scopeRecent($query)
    {
        return $query->orderBy("id", "desc");
    }
}