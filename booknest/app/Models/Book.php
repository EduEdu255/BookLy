<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'title',
        'description',
        'author',
        'cover',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public static function getFiltered(User $user, ?string $status)
    {
        $query = $user->books();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }
}
