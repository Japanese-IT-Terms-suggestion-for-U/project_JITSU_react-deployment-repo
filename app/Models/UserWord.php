<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWord extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['user_id', 'word_number', 'is_favorite', 'is_memorized'];

    protected $casts = [
        'is_favorite' => 'boolean',
        'is_memorized' => 'boolean',
    ];

    public function word()
    {
        return $this->belongsTo(Word::class, 'word_number', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
