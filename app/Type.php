<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 */
class Type extends Model
{
    protected $table = 'types';

    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    protected $guarded = [];

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
}