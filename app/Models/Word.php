<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $primaryKey = 'word_number';

    public $timestamps = false;

    protected $fillable = ['japanese', 'korean', 'korean_definition', 'tag'];
}
