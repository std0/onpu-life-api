<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 */
class Group extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

    protected $hidden = [
        'id',
        'pivot'
    ];

    public function students()
    {
        return $this->hasMany('App\Student');
    }

    public function lessons()
    {
        return $this->belongsToMany('App\Lesson', 'group_lesson', 'group_id', 'lesson_id');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'group_subject', 'group_id', 'subject_id');
    }
}