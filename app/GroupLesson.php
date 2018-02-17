<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupLesson
 */
class GroupLesson extends Model
{
    protected $table = 'group_lesson';

    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'lesson_id'
    ];

    protected $guarded = [];
}