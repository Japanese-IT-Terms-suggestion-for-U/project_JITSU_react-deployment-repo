<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var string
     * @access private
     */
    protected $primaryKey = 'tag_id';

    /**
     * @var bool
     * @access public
     */
    public $timestamps = false;

    /**
     * @var array
     * @access protected
     */
    protected $fillable = ['tag_name'];
}
