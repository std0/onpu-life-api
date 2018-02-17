<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 */
class Student extends Model
{
    protected $table = 'students';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'group_id'
    ];

    protected $guarded = [];

    protected $hidden = [
        'id',
        'group_id'
    ];

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function getLessons($day, $parity)
    {
        $lessons = $this->group->lessons
            ->where('week_day', $day)
            ->whereIn('parity', [0, $parity]);

        foreach ($lessons as $lesson) {
            $lesson = $lesson->makeHidden('groups');
        }

        return $lessons->values();
    }

    public function getSubjects()
    {
        $subjects = $this->group->subjects;

        foreach ($subjects as $subject) {
            $subject->teachers;
            $subject = $subject->makeHidden('groups');
        }

        return $subjects;
    }
}