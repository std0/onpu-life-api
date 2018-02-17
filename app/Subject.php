<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 */
class Subject extends Model
{
    protected $table = 'subjects';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'form_id'
    ];

    protected $guarded = [];

    protected $appends = [
        'exam_form'
    ];

    protected $hidden = [
        'form_id',
        'form',
        'pivot'
    ];

    public function form()
    {
        return $this->belongsTo('App\ExamForm');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_subject', 'subject_id', 'group_id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'subject_teacher', 'subject_id', 'teacher_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function getExamFormAttribute()
    {
        return $this->form->form;
    }
}