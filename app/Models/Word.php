<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $primaryKey = 'word_number';

    public $timestamps = false;

    protected $fillable = ['word_number', 'japanese', 'korean', 'korean_definition', 'tag_id'];

    public function userWord()
    {
        return $this->hasMany(UserWord::class, 'word_number', 'word_number');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
