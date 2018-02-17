<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 */
class Teacher extends Model
{
    protected $table = 'teachers';

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'second_name',
        'last_name'
    ];

    protected $guarded = [];

    protected $hidden = [
        'id',
        'pivot'
    ];

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function getLessons($day, $parity)
    {
        $lessons = [];

        foreach ($this->subjects as $subject) {
            $subjectLessons = $subject->lessons
                    ->where('week_day', $day)
                    ->whereIn('parity', [0, $parity])
                    ->all();
            
            $lessons = array_merge($lessons, $subjectLessons);
        }

        foreach ($lessons as $lesson) {
            $lesson->groups;
            $lesson = $lesson->makeHidden('teachers');
        }

        return collect($lessons);
    }

    public function getSubjects()
    {
        $subjects = $this->subjects;

        foreach ($subjects as $subject) {
            $subject->groups;
            $subject = $subject->makeHidden('teachers');
        }

        return $subjects;
    }
}