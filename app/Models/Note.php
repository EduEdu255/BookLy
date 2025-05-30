<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'content',
        'book_id'
    ];

    public function book(){
        return $this->BelongsTo(Book::class);
    }
}
