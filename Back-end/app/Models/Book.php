<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'external_id',
        'title',
        'description',
        'author',
        'status',
        'published_at',
        'user_id'
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
