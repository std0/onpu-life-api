<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 */
class Lesson extends Model
{
    protected $table = 'lessons';

    public $timestamps = false;

    protected $fillable = [
        'subject_id',
        'room',
        'order',
        'week_day',
        'type_id',
        'parity'
    ];

    protected $guarded = [];

    protected $appends = [
        'lesson_type', 
        'subject_name', 
        'teachers'
    ];

    protected $hidden = [
        'id',
        'subject',
        'week_day',
        'type_id',
        'type',
        'parity',
        'pivot'
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_lesson', 'lesson_id', 'group_id');
    }

    public function subject()
    {
         return $this->belongsTo('App\Subject');
    }

    public function type()
    {
         return $this->belongsTo('App\Type');
    }

    public function getLessonTypeAttribute()
    {
        return $this->type->type;
    }

    public function getSubjectNameAttribute()
    {
        return $this->subject->name;
    }

    public function getTeachersAttribute()
    {
        return $this->subject->teachers;
    }
}