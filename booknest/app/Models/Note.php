<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'book_external_id',
        'book_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
